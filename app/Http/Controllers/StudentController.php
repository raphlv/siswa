<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Violation;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class')) {
            $query->where('class', $request->input('class'));
        }

        $students = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        
        // Get all unique classes for filter dropdown
        $classes = Student::select('class')->distinct()->orderBy('class', 'asc')->pluck('class');

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|size:10|unique:students,nisn',
            'name' => 'required|string|max:150',
            'class' => 'required|string|max:50',
            'gender' => 'required|in:L,P',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.size' => 'NISN harus berisi tepat 10 karakter.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'class.required' => 'Kelas wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Student $student)
    {
        $student->load(['studentViolations.violation']);
        $violations = Violation::orderBy('name', 'asc')->get();
        return view('students.show', compact('student', 'violations'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|size:10|unique:students,nisn,' . $student->id,
            'name' => 'required|string|max:150',
            'class' => 'required|string|max:50',
            'gender' => 'required|in:L,P',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.size' => 'NISN harus berisi tepat 10 karakter.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'class.required' => 'Kelas wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
