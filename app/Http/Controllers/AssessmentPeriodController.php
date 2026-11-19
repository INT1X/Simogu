<?php

namespace App\Http\Controllers;

use App\Models\AssessmentPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AssessmentPeriodController extends Controller
{
    /**
     * Menampilkan daftar periode penilaian.
     */
    public function index()
    {
        $assessmentPeriods = AssessmentPeriod::query()
            ->orderByDesc('academic_year')
            ->orderByRaw("CASE WHEN semester = 'ganjil' THEN 1 ELSE 2 END")
            ->paginate(10);

        return view('admin.assessment-periods.index', compact('assessmentPeriods'));
    }

    /**
     * Menampilkan form tambah periode.
     */
    public function create()
    {
        return view('admin.assessment-periods.create');
    }

    /**
     * Menyimpan periode baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => [
                'required',
                'regex:/^\d{4}\/\d{4}$/',
            ],
            'semester' => [
                'required',
                Rule::in(['ganjil', 'genap']),
            ],
            'start_date' => ['nullable', 'date'],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'status' => [
                'required',
                Rule::in(['draft', 'active', 'closed']),
            ],
        ], [
            'academic_year.required' => 'Tahun ajaran wajib diisi.',
            'academic_year.regex' => 'Format tahun ajaran harus seperti 2026/2027.',
            'semester.required' => 'Semester wajib dipilih.',
            'semester.in' => 'Semester tidak valid.',
            'start_date.date' => 'Tanggal mulai tidak valid.',
            'end_date.date' => 'Tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'status.required' => 'Status periode wajib dipilih.',
            'status.in' => 'Status periode tidak valid.',
        ]);

        $exists = AssessmentPeriod::where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'semester' => 'Periode untuk tahun ajaran dan semester tersebut sudah tersedia.',
            ]);
        }

        DB::transaction(function () use ($validated) {
            if ($validated['status'] === 'active') {
                AssessmentPeriod::where('status', 'active')
                    ->update(['status' => 'closed']);
            }

            AssessmentPeriod::create($validated);
        });

        return redirect()
            ->route('admin.assessment-periods.index')
            ->with('success', 'Periode penilaian berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit periode.
     */
    public function edit(AssessmentPeriod $assessmentPeriod)
    {
        return view('admin.assessment-periods.edit', compact('assessmentPeriod'));
    }

    /**
     * Memperbarui periode.
     */
    public function update(Request $request, AssessmentPeriod $assessmentPeriod)
    {
        $validated = $request->validate([
            'academic_year' => [
                'required',
                'regex:/^\d{4}\/\d{4}$/',
            ],
            'semester' => [
                'required',
                Rule::in(['ganjil', 'genap']),
            ],
            'start_date' => ['nullable', 'date'],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'status' => [
                'required',
                Rule::in(['draft', 'active', 'closed']),
            ],
        ], [
            'academic_year.required' => 'Tahun ajaran wajib diisi.',
            'academic_year.regex' => 'Format tahun ajaran harus seperti 2026/2027.',
            'semester.required' => 'Semester wajib dipilih.',
            'semester.in' => 'Semester tidak valid.',
            'start_date.date' => 'Tanggal mulai tidak valid.',
            'end_date.date' => 'Tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'status.required' => 'Status periode wajib dipilih.',
            'status.in' => 'Status periode tidak valid.',
        ]);

        $exists = AssessmentPeriod::where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->where('id', '!=', $assessmentPeriod->id)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'semester' => 'Periode untuk tahun ajaran dan semester tersebut sudah tersedia.',
            ]);
        }

        DB::transaction(function () use ($validated, $assessmentPeriod) {
            if ($validated['status'] === 'active') {
                AssessmentPeriod::where('status', 'active')
                    ->where('id', '!=', $assessmentPeriod->id)
                    ->update(['status' => 'closed']);
            }

            $assessmentPeriod->update($validated);
        });

        return redirect()
            ->route('admin.assessment-periods.index')
            ->with('success', 'Periode penilaian berhasil diperbarui.');
    }

    /**
     * Menghapus periode jika belum digunakan oleh penilaian.
     */
    public function destroy(AssessmentPeriod $assessmentPeriod)
    {
        if ($assessmentPeriod->assessments()->exists()) {
            return redirect()
                ->route('admin.assessment-periods.index')
                ->with('error', 'Periode tidak dapat dihapus karena sudah digunakan oleh data penilaian.');
        }

        $assessmentPeriod->delete();

        return redirect()
            ->route('admin.assessment-periods.index')
            ->with('success', 'Periode penilaian berhasil dihapus.');
    }
}
