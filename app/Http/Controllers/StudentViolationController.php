<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Violation;
use App\Models\StudentViolation;
use Illuminate\Http\Request;

class StudentViolationController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentViolation::with(['student', 'violation']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('class', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $cat = $request->input('category');
            $query->whereHas('violation', function($q) use ($cat) {
                $q->where('category', $cat);
            });
        }

        $logs = $query->orderBy('reported_at', 'desc')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('logs.index', compact('logs'));
    }

    public function create()
    {
        $students = Student::orderBy('name', 'asc')->get();
        $violations = Violation::orderBy('category', 'asc')->orderBy('name', 'asc')->get();
        return view('logs.create', compact('students', 'violations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'violation_id' => 'required|exists:violations,id',
            'description' => 'nullable|string',
            'reported_at' => 'required|date',
        ], [
            'student_id.required' => 'Siswa harus dipilih.',
            'student_id.exists' => 'Siswa tidak valid.',
            'violation_id.required' => 'Jenis pelanggaran harus dipilih.',
            'violation_id.exists' => 'Jenis pelanggaran tidak valid.',
            'reported_at.required' => 'Tanggal laporan harus diisi.',
            'reported_at.date' => 'Tanggal laporan harus berupa tanggal yang valid.',
        ]);

        // Fetch violation point
        $violation = Violation::findOrFail($request->input('violation_id'));
        $validated['points'] = $violation->points;

        StudentViolation::create($validated);

        // If requested from a student's detail page, redirect back there
        if ($request->has('redirect_to_student')) {
            return redirect()->route('students.show', $request->input('student_id'))
                ->with('success', 'Pelanggaran berhasil dicatat.');
        }

        return redirect()->route('logs.index')->with('success', 'Laporan pelanggaran berhasil dicatat.');
    }

    public function destroy(StudentViolation $log)
    {
        $studentId = $log->student_id;
        $log->delete();

        if (request()->has('redirect_to_student')) {
            return redirect()->route('students.show', $studentId)
                ->with('success', 'Laporan pelanggaran berhasil dihapus.');
        }

        return redirect()->route('logs.index')->with('success', 'Laporan pelanggaran berhasil dihapus.');
    }
}
