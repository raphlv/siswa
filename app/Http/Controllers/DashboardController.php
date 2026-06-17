<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Violation;
use App\Models\StudentViolation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalViolationTypes = Violation::count();
        $totalIncidents = StudentViolation::count();
        $totalPoints = Student::sum('points');

        // Top 5 students with highest points
        $topStudents = Student::orderBy('points', 'desc')
            ->where('points', '>', 0)
            ->take(5)
            ->get();

        // Recent 5 violation logs
        $recentIncidents = StudentViolation::with(['student', 'violation'])
            ->orderBy('reported_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // Count of incidents by class
        $classStats = Student::select('students.class')
            ->selectRaw('COALESCE(SUM(student_violations.points), 0) as total_points')
            ->selectRaw('COUNT(student_violations.id) as incident_count')
            ->leftJoin('student_violations', 'students.id', '=', 'student_violations.student_id')
            ->groupBy('students.class')
            ->orderBy('total_points', 'desc')
            ->get();

        // Count of incidents by category (Ringan, Sedang, Berat)
        $categoryStats = DB::table('student_violations')
            ->join('violations', 'student_violations.violation_id', '=', 'violations.id')
            ->select('violations.category', DB::raw('count(*) as count'), DB::raw('sum(student_violations.points) as total_points'))
            ->groupBy('violations.category')
            ->get()
            ->keyBy('category');

        $categories = ['Ringan', 'Sedang', 'Berat'];
        $categoryChartData = [];
        foreach ($categories as $cat) {
            $categoryChartData[$cat] = [
                'count' => $categoryStats->has($cat) ? $categoryStats->get($cat)->count : 0,
                'points' => $categoryStats->has($cat) ? $categoryStats->get($cat)->total_points : 0,
            ];
        }

        return view('dashboard', compact(
            'totalStudents',
            'totalViolationTypes',
            'totalIncidents',
            'totalPoints',
            'topStudents',
            'recentIncidents',
            'classStats',
            'categoryChartData'
        ));
    }
}
