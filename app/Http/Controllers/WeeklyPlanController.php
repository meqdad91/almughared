<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\WeeklyPlan;
use App\Services\WeeklyPlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeeklyPlanController extends Controller
{
    protected WeeklyPlanService $service;

    public function __construct(WeeklyPlanService $service)
    {
        $this->service = $service;
    }

    // ─── Trainer Methods ───

    public function index()
    {
        $trainer = Auth::guard('trainer')->user();
        $plans = WeeklyPlan::where('trainer_id', $trainer->id)
            ->with('session')
            ->latest()
            ->paginate(10);

        return view('trainer.weekly_plans.index', compact('plans', 'trainer'));
    }

    public function downloadTemplate()
    {
        $path = $this->service->generateTemplate();

        return response()->download($path, 'weekly_plan_template.docx')->deleteFileAfterSend();
    }

    public function create(Session $session)
    {
        $trainer = Auth::guard('trainer')->user();
        abort_unless($session->trainer_id === $trainer->id, 403);

        return view('trainer.weekly_plans.create', compact('session'));
    }

    public function store(Request $request, Session $session)
    {
        $trainer = Auth::guard('trainer')->user();
        abort_unless($session->trainer_id === $trainer->id, 403);

        $request->validate([
            'file' => 'required|file|mimes:docx|max:5120',
        ]);

        $file = $request->file('file');

        try {
            $subjects = $this->service->parseDocx($file->getRealPath());
        } catch (\Exception $e) {
            return back()->withErrors(['file' => $e->getMessage()]);
        }

        $storedPath = $file->store('weekly_plans', 'public');

        WeeklyPlan::create([
            'session_id' => $session->id,
            'trainer_id' => $trainer->id,
            'file_path' => $storedPath,
            'parsed_data' => $subjects,
            'status' => 'pending',
        ]);

        return redirect()->route('trainer.weekly-plans.index')
            ->with('success', 'Weekly plan uploaded successfully and sent for review.');
    }

    public function show(WeeklyPlan $weeklyPlan)
    {
        $trainer = Auth::guard('trainer')->user();
        abort_unless($weeklyPlan->trainer_id === $trainer->id, 403);
        $weeklyPlan->load('session');

        return view('trainer.weekly_plans.show', compact('weeklyPlan'));
    }

    // ─── QA Methods ───

    public function pendingForQa()
    {
        $plans = WeeklyPlan::pending()
            ->with(['session', 'trainer'])
            ->latest()
            ->paginate(10);

        return view('qa.weekly_plans.index', compact('plans'));
    }

    public function showForQa(WeeklyPlan $weeklyPlan)
    {
        $weeklyPlan->load(['session', 'trainer']);
        return view('qa.weekly_plans.show', compact('weeklyPlan'));
    }

    // ─── Admin Methods ───

    public function pendingForAdmin()
    {
        $plans = WeeklyPlan::pending()
            ->with(['session', 'trainer'])
            ->latest()
            ->paginate(10);

        return view('admin.weekly_plans.index', compact('plans'));
    }

    public function indexForAdmin()
    {
        $plans = WeeklyPlan::with(['session', 'trainer'])
            ->latest()
            ->paginate(10);

        return view('admin.weekly_plans.index', compact('plans'));
    }

    public function showForAdmin(WeeklyPlan $weeklyPlan)
    {
        $weeklyPlan->load(['session', 'trainer']);
        return view('admin.weekly_plans.show', compact('weeklyPlan'));
    }

    // ─── Shared Approve/Decline ───

    public function approve(WeeklyPlan $weeklyPlan)
    {
        abort_unless($weeklyPlan->status === 'pending', 403);

        $guard = $this->detectGuard();
        $user = Auth::guard($guard)->user();

        $weeklyPlan->update([
            'status' => 'approved',
            'reviewed_by_type' => get_class($user),
            'reviewed_by_id' => $user->id,
            'reviewed_at' => now(),
            'decline_reason' => null,
        ]);

        $this->service->createSubjectsFromPlan($weeklyPlan);

        $redirectRoute = $guard === 'qa'
            ? 'qa.weekly-plans.pending'
            : 'admin.users.weekly-plans.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Weekly plan approved. ' . count($weeklyPlan->parsed_data) . ' subjects created.');
    }

    public function decline(Request $request, WeeklyPlan $weeklyPlan)
    {
        abort_unless($weeklyPlan->status === 'pending', 403);

        $request->validate([
            'decline_reason' => 'required|string',
        ]);

        $guard = $this->detectGuard();
        $user = Auth::guard($guard)->user();

        $weeklyPlan->update([
            'status' => 'declined',
            'decline_reason' => $request->decline_reason,
            'reviewed_by_type' => get_class($user),
            'reviewed_by_id' => $user->id,
            'reviewed_at' => now(),
        ]);

        $redirectRoute = $guard === 'qa'
            ? 'qa.weekly-plans.pending'
            : 'admin.users.weekly-plans.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Weekly plan declined.');
    }

    private function detectGuard(): string
    {
        if (Auth::guard('qa')->check()) {
            return 'qa';
        }
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }
        abort(403);
    }
}
