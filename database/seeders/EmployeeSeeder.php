<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Division;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = Division::all();
        $dummy = [
            [
                'image' => 'https://randomuser.me/api/portraits/men/1.jpg',
                'name' => 'Budi Santoso',
                'phone' => '081234567891',
                'division' => 'Mobile Apps',
                'position' => 'Mobile Developer',
            ],
            [
                'image' => 'https://randomuser.me/api/portraits/women/2.jpg',
                'name' => 'Siti Aminah',
                'phone' => '081234567892',
                'division' => 'QA',
                'position' => 'QA Engineer',
            ],
            [
                'image' => 'https://randomuser.me/api/portraits/men/3.jpg',
                'name' => 'Andi Wijaya',
                'phone' => '081234567893',
                'division' => 'Full Stack',
                'position' => 'Full Stack Developer',
            ],
            [
                'image' => 'https://randomuser.me/api/portraits/women/4.jpg',
                'name' => 'Dewi Lestari',
                'phone' => '081234567894',
                'division' => 'Backend',
                'position' => 'Backend Developer',
            ],
            [
                'image' => 'https://randomuser.me/api/portraits/men/5.jpg',
                'name' => 'Rudi Hartono',
                'phone' => '081234567895',
                'division' => 'Frontend',
                'position' => 'Frontend Developer',
            ],
            [
                'image' => 'https://randomuser.me/api/portraits/women/6.jpg',
                'name' => 'Maya Sari',
                'phone' => '081234567896',
                'division' => 'UI/UX Designer',
                'position' => 'UI/UX Designer',
            ],
        ];

        foreach ($dummy as $data) {
            $division = $divisions->where('name', $data['division'])->first();
            if ($division) {
                Employee::create([
                    'image' => $data['image'],
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'division_id' => $division->id,
                    'position' => $data['position'],
                ]);
            }
        }
    }
} 