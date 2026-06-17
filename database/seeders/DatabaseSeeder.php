<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Violation;
use App\Models\StudentViolation;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        StudentViolation::truncate();
        Violation::truncate();
        Student::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // Seed Default Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@siswa.com',
            'password' => Hash::make('admin123'),
        ]);

        // Seed Violations
        $violations = [
            // Ringan
            ['name' => 'Terlambat masuk sekolah', 'category' => 'Ringan', 'points' => 10],
            ['name' => 'Tidak memakai atribut sekolah lengkap (dasi, topi, kaos kaki)', 'category' => 'Ringan', 'points' => 5],
            ['name' => 'Rambut tidak rapi atau melebihi kerah baju (bagi laki-laki)', 'category' => 'Ringan', 'points' => 5],
            ['name' => 'Membuang sampah sembarangan di area sekolah', 'category' => 'Ringan', 'points' => 5],
            ['name' => 'Pakaian seragam dikeluarkan atau tidak rapi', 'category' => 'Ringan', 'points' => 5],
            
            // Sedang
            ['name' => 'Tidak mengikuti upacara bendera tanpa alasan sah', 'category' => 'Sedang', 'points' => 15],
            ['name' => 'Meninggalkan kelas / sekolah tanpa izin sebelum jam pulang', 'category' => 'Sedang', 'points' => 20],
            ['name' => 'Membawa/menggunakan handphone saat KBM berlangsung tanpa instruksi guru', 'category' => 'Sedang', 'points' => 15],
            ['name' => 'Membuat keributan atau mengganggu ketertiban kelas', 'category' => 'Sedang', 'points' => 10],
            ['name' => 'Makan atau minum di dalam kelas saat pelajaran berlangsung', 'category' => 'Sedang', 'points' => 10],
            
            // Berat
            ['name' => 'Membolos sekolah (tidak masuk tanpa keterangan)', 'category' => 'Berat', 'points' => 30],
            ['name' => 'Merusak sarana dan prasarana sekolah secara sengaja', 'category' => 'Berat', 'points' => 45],
            ['name' => 'Melakukan perundungan (bullying) fisik atau verbal', 'category' => 'Berat', 'points' => 50],
            ['name' => 'Membawa, menyimpan, atau menghisap rokok / vape di lingkungan sekolah', 'category' => 'Berat', 'points' => 40],
            ['name' => 'Membawa senjata tajam atau barang berbahaya lainnya', 'category' => 'Berat', 'points' => 75],
            ['name' => 'Terlibat tawuran antarpelajar', 'category' => 'Berat', 'points' => 100],
            ['name' => 'Melakukan kecurangan saat ujian nasional / ulangan umum', 'category' => 'Berat', 'points' => 35],
        ];

        $violationModels = [];
        foreach ($violations as $v) {
            $violationModels[] = Violation::create($v);
        }

        // Seed Students
        $students = [
            ['nisn' => '0081234561', 'name' => 'Aditya Pratama', 'class' => 'XI IPA 1', 'gender' => 'L', 'points' => 0],
            ['nisn' => '0081234562', 'name' => 'Budi Santoso', 'class' => 'XI IPA 1', 'gender' => 'L', 'points' => 0],
            ['nisn' => '0081234563', 'name' => 'Citra Lestari', 'class' => 'X IPS 2', 'gender' => 'P', 'points' => 0],
            ['nisn' => '0091234564', 'name' => 'Dimas Anggara', 'class' => 'X IPA 3', 'gender' => 'L', 'points' => 0],
            ['nisn' => '0071234565', 'name' => 'Eka Wahyuni', 'class' => 'XII IPS 1', 'gender' => 'P', 'points' => 0],
            ['nisn' => '0071234566', 'name' => 'Fahri Hidayat', 'class' => 'XII IPA 2', 'gender' => 'L', 'points' => 0],
            ['nisn' => '0081234567', 'name' => 'Gita Permata', 'class' => 'XI IPS 3', 'gender' => 'P', 'points' => 0],
            ['nisn' => '0091234568', 'name' => 'Hendra Wijaya', 'class' => 'X IPS 1', 'gender' => 'L', 'points' => 0],
            ['nisn' => '0081234569', 'name' => 'Indah Cahyani', 'class' => 'XI IPA 2', 'gender' => 'P', 'points' => 0],
            ['nisn' => '0071234570', 'name' => 'Joko Susilo', 'class' => 'XII IPS 3', 'gender' => 'L', 'points' => 0],
        ];

        $studentModels = [];
        foreach ($students as $s) {
            $studentModels[] = Student::create($s);
        }

        // Seed some sample student violations (this will trigger points updates automatically!)
        $sampleLogs = [
            [
                'student_index' => 1, // Budi Santoso
                'violation_index' => 0, // Terlambat masuk sekolah (10 pts)
                'description' => 'Terlambat bangun karena tidur larut malam',
                'reported_at' => now()->subDays(5)->format('Y-m-d'),
            ],
            [
                'student_index' => 1, // Budi Santoso
                'violation_index' => 2, // Rambut tidak rapi (5 pts)
                'description' => 'Rambut bagian samping melebihi daun telinga',
                'reported_at' => now()->subDays(2)->format('Y-m-d'),
            ],
            [
                'student_index' => 3, // Dimas Anggara
                'violation_index' => 7, // Membawa HP saat KBM (15 pts)
                'description' => 'Membuka media sosial saat jam pelajaran matematika',
                'reported_at' => now()->subDays(3)->format('Y-m-d'),
            ],
            [
                'student_index' => 7, // Hendra Wijaya
                'violation_index' => 10, // Membolos sekolah (30 pts)
                'description' => 'Tertangkap nongkrong di warung belakang sekolah saat jam pelajaran',
                'reported_at' => now()->subDays(1)->format('Y-m-d'),
            ],
            [
                'student_index' => 9, // Joko Susilo
                'violation_index' => 12, // Bullying (50 pts)
                'description' => 'Mengolok-olok teman sekelas hingga menangis',
                'reported_at' => now()->subDays(4)->format('Y-m-d'),
            ],
        ];

        foreach ($sampleLogs as $log) {
            $student = $studentModels[$log['student_index']];
            $violation = $violationModels[$log['violation_index']];
            
            StudentViolation::create([
                'student_id' => $student->id,
                'violation_id' => $violation->id,
                'description' => $log['description'],
                'points' => $violation->points,
                'reported_at' => $log['reported_at'],
            ]);
        }
    }
}
