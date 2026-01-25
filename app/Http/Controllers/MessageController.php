<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Message;
use App\Models\Qa;
use App\Models\Trainee;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class MessageController extends Controller
{
    protected function currentUser()
    {
        return Auth::user();
    }

    protected function currentUserType(): string
    {
        $user = $this->currentUser();

        return $user ? get_class($user) : '';
    }

    public function index()
    {
        $user = $this->currentUser();

        // All messages where current user is sender or receiver
        $allMessages = Message::with(['sender', 'receiver'])
            ->where(function ($query) use ($user) {
                $query->where('sender_type', get_class($user))
                    ->where('sender_id', $user->id);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('receiver_type', get_class($user))
                    ->where('receiver_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->get();

        // Build conversations list (similar to Messenger: each unique other user)
        $conversations = [];
        foreach ($allMessages as $message) {
            if ($message->sender_type === get_class($user) && $message->sender_id === $user->id) {
                $other = $message->receiver;
            } else {
                $other = $message->sender;
            }

            if (! $other) {
                continue;
            }

            $type = $this->mapClassToType(get_class($other));
            if (! $type) {
                continue;
            }

            $key = $type.':'.$other->id;

            if (! isset($conversations[$key])) {
                $conversations[$key] = [
                    'type' => $type,
                    'id' => $other->id,
                    'name' => $other->name ?? ucfirst($type).' #'.$other->id,
                    'role_label' => ucfirst($type),
                    'last_message_at' => $message->created_at,
                    'last_message_body' => $message->body,
                    'unread_count' => 0,
                ];
            }

            // Update last message if this one is newer
            if ($message->created_at->gt($conversations[$key]['last_message_at'])) {
                $conversations[$key]['last_message_at'] = $message->created_at;
                $conversations[$key]['last_message_body'] = $message->body;
            }
        }

        // Calculate unread counts for each conversation
        foreach ($conversations as $key => &$conversation) {
            $otherClass = $this->mapTypeToClass($conversation['type']);
            if ($otherClass) {
                $unreadCount = Message::where('sender_type', $otherClass)
                    ->where('sender_id', $conversation['id'])
                    ->where('receiver_type', get_class($user))
                    ->where('receiver_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
                $conversation['unread_count'] = $unreadCount;
            }
        }

        // Sort conversations by last message date desc
        $conversations = collect($conversations)->sortByDesc('last_message_at')->values();

        // Determine active conversation (selected contact)
        $requestedType = request()->query('type');
        $requestedId = request()->query('id');

        $activeConversation = null;
        $activeUser = null;

        if ($requestedType && $requestedId) {
            $class = $this->mapTypeToClass($requestedType);
            if ($class) {
                $activeUser = $class::find($requestedId);
                if ($activeUser) {
                    $activeConversation = [
                        'type' => $requestedType,
                        'id' => (int) $requestedId,
                    ];
                }
            }
        }

        // Default to the first conversation if none explicitly selected
        if (! $activeConversation && $conversations->isNotEmpty()) {
            $first = $conversations->first();
            $class = $this->mapTypeToClass($first['type']);
            $activeUser = $class ? $class::find($first['id']) : null;
            if ($activeUser) {
                $activeConversation = [
                    'type' => $first['type'],
                    'id' => $first['id'],
                ];
            }
        }

        // Messages for the active conversation only
        $conversationMessages = collect();
        if ($activeUser) {
            $conversationMessages = Message::with(['sender', 'receiver'])
                ->where(function ($query) use ($user, $activeUser) {
                    $query->where('sender_type', get_class($user))
                        ->where('sender_id', $user->id)
                        ->where('receiver_type', get_class($activeUser))
                        ->where('receiver_id', $activeUser->id);
                })
                ->orWhere(function ($query) use ($user, $activeUser) {
                    $query->where('sender_type', get_class($activeUser))
                        ->where('sender_id', $activeUser->id)
                        ->where('receiver_type', get_class($user))
                        ->where('receiver_id', $user->id);
                })
                ->orderBy('created_at')
                ->get();

            // Mark messages as read when viewing conversation
            Message::where('sender_type', get_class($activeUser))
                ->where('sender_id', $activeUser->id)
                ->where('receiver_type', get_class($user))
                ->where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        $admins = Admin::all();
        $qas = Qa::all();
        $trainers = Trainer::all();
        $trainees = Trainee::all();

        $view = $this->resolveViewForCurrentUser();

        return view($view, [
            'user' => $user,
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
            'activeUser' => $activeUser,
            'conversationMessages' => $conversationMessages,
            'admins' => $admins,
            'qas' => $qas,
            'trainers' => $trainers,
            'trainees' => $trainees,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_type' => 'required|string',
            'receiver_id' => 'required|integer',
            'body' => 'required|string|max:2000',
        ]);

        $user = $this->currentUser();

        $type = $request->input('receiver_type');
        $receiverClass = $this->mapTypeToClass($type);
        if (! $receiverClass) {
            abort(403, 'Invalid receiver type');
        }

        $receiver = $receiverClass::find($request->input('receiver_id'));
        if (! $receiver) {
            abort(404, 'Receiver not found');
        }

        Message::create([
            'sender_type' => get_class($user),
            'sender_id' => $user->id,
            'receiver_type' => $receiverClass,
            'receiver_id' => $receiver->id,
            'body' => $request->input('body'),
        ]);

        return redirect()
            ->route('messages.index', ['type' => $type, 'id' => $receiver->id])
            ->with('success', 'Message sent successfully.');
    }

    protected function mapTypeToClass(string $type): ?string
    {
        return match ($type) {
            'admin' => Admin::class,
            'qa' => Qa::class,
            'trainer' => Trainer::class,
            'trainee' => Trainee::class,
            default => null,
        };
    }

    protected function mapClassToType(string $class): ?string
    {
        return match ($class) {
            Admin::class => 'admin',
            Qa::class => 'qa',
            Trainer::class => 'trainer',
            Trainee::class => 'trainee',
            default => null,
        };
    }

    protected function resolveViewForCurrentUser(): string
    {
        if (Auth::guard('admin')->check()) {
            return 'messages.admin';
        }

        if (Auth::guard('trainee')->check()) {
            return 'messages.trainee';
        }

        if (Auth::guard('trainer')->check()) {
            return 'messages.trainer';
        }

        if (Auth::guard('qa')->check()) {
            return 'messages.qa';
        }

        return 'messages.index';
    }

    /**
     * Get total unread messages count for the current user
     */
    public static function getUnreadCount($user = null): int
    {
        if (! $user) {
            $user = Auth::user();
        }

        if (! $user) {
            return 0;
        }

        return Message::where('receiver_type', get_class($user))
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->count();
    }
}

