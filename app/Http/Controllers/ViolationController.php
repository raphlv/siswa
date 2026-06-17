<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    public function index(Request $request)
    {
        $query = Violation::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $violations = $query->orderBy('category', 'asc')->orderBy('points', 'asc')->paginate(10)->withQueryString();

        return view('violations.index', compact('violations'));
    }

    public function create()
    {
        return view('violations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Ringan,Sedang,Berat',
            'points' => 'required|integer|min:1|max:100',
        ], [
            'name.required' => 'Nama pelanggaran wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
            'points.required' => 'Poin wajib diisi.',
            'points.min' => 'Poin minimal adalah 1.',
            'points.max' => 'Poin maksimal adalah 100.',
        ]);

        Violation::create($validated);

        return redirect()->route('violations.index')->with('success', 'Jenis pelanggaran baru berhasil ditambahkan.');
    }

    public function edit(Violation $violation)
    {
        return view('violations.edit', compact('violation'));
    }

    public function update(Request $request, Violation $violation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Ringan,Sedang,Berat',
            'points' => 'required|integer|min:1|max:100',
        ], [
            'name.required' => 'Nama pelanggaran wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
            'points.required' => 'Poin wajib diisi.',
            'points.min' => 'Poin minimal adalah 1.',
            'points.max' => 'Poin maksimal adalah 100.',
        ]);

        $violation->update($validated);

        return redirect()->route('violations.index')->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy(Violation $violation)
    {
        $violation->delete();
        return redirect()->route('violations.index')->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }
}
