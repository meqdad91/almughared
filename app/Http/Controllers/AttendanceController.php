<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Session;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function showAttendanceForm(Subject $subject)
    {
        $subject->load('session.trainees');
        $trainees = $subject->session->trainees;

        $existingAttendance = $subject->attendances->keyBy('trainee_id');

        return view('trainer.attendance', compact('subject', 'trainees', 'existingAttendance'));
    }

    public function storeAttendance(Request $request, Subject $subject)
    {
        $subject->load('session.trainees');
        $traineeIds = $subject->session->trainees->pluck('id');

        $presentIds = $request->input('attendance', []);

        foreach ($traineeIds as $traineeId) {
            Attendance::updateOrCreate(
                ['subject_id' => $subject->id, 'trainee_id' => $traineeId],
                ['status' => in_array($traineeId, $presentIds) ? 'present' : 'absent']
            );
        }

        return redirect()->route('trainer.subjects.active', $subject->session_id)->with('success', 'Attendance saved successfully.');
    }

    public function traineeAttendance()
    {
        $trainee = Auth::guard('trainee')->user();

        $attendances = Attendance::where('trainee_id', $trainee->id)
            ->with('subject.session')
            ->latest()
            ->paginate(15);

        $totalSubjects = Attendance::where('trainee_id', $trainee->id)->count();
        $presentCount = Attendance::where('trainee_id', $trainee->id)->where('status', 'present')->count();
        $absentCount = $totalSubjects - $presentCount;
        $attendanceRate = $totalSubjects > 0 ? round(($presentCount / $totalSubjects) * 100, 1) : 0;

        return view('trainee.attendance', compact('attendances', 'totalSubjects', 'presentCount', 'absentCount', 'attendanceRate'));
    }

    public function adminAttendance(Request $request)
    {
        $sessions = Session::all();

        $attendances = Attendance::with('subject.session', 'trainee')
            ->when($request->session_id, function ($q) use ($request) {
                $q->whereHas('subject', function ($q) use ($request) {
                    $q->where('session_id', $request->session_id);
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.attendance', compact('attendances', 'sessions'));
    }
}
