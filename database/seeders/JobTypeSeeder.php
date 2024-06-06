<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobtypes = [
            'Full Time',
            'Part Time',
            'Freelance',
            'Remote',
        ];
        foreach ($jobtypes as $job) {
            JobType::create([
                'name' => $job,
            ]);
        }
    }
}
