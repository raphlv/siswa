<div align="center">

# Siswa - Academic Information Management System (SIAKAD)

### *Student Master Data, Online Gradebook, Rapor Generation, and Attendance Tracking*

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)

---

</div>

## Overview

Siswa is a comprehensive school academic management system (SIAKAD). Built for primary and secondary schools, it manages student master records (NISN), teacher class assignments, daily attendance logs, online gradebooks, and automated report card (Rapor) generation.

---

## Key Features

### 1. Student and Teacher Record Management
- Complete NISN student profiles, parent info, and academic history.
- Teacher subject assignment and class homeroom coordinator management.

### 2. Online Gradebook and Automated Rapor Generator
- Numerical and letter grading (Knowledge and Skills assessment).
- Automated GPA (IPK) and class ranking calculation.
- PDF Report Card (Rapor Digital) printing compliant with national curriculum standards.

### 3. Attendance and Schedule Management
- Daily student attendance logging (Present, Sick, Permitted, Absent).
- Timetable schedule generator per class room.

---

## Installation and Setup

`ash
git clone https://github.com/raphlv/siswa.git
cd siswa

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve
`

---

## License and Author

Distributed under the MIT License.

Author: Pangeran Ryan Pahlevi (https://github.com/raphlv)  
Email: pangeranryan080504@gmail.com  

---
<div align="center">
  <sub>Automated Sync Enabled for Contribution Tracking | Last Updated: 2026-08-18 14:40:47</sub>
</div>