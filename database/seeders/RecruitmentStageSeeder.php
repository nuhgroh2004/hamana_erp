<?php

namespace Database\Seeders;

use App\Modules\Recruitment\Models\Stage;
use Illuminate\Database\Seeder;

class RecruitmentStageSeeder extends Seeder
{
    public function run(): void
    {
        $stages = ['Baru', 'Screening', 'Tes Teknis', 'Interview HR', 'Interview User', 'Offering', 'Hired'];

        foreach ($stages as $i => $name) {
            Stage::updateOrCreate(['name' => $name], [
                'order' => $i + 1,
                'is_active' => true,
                'is_final' => $name === 'Hired',
            ]);
        }
    }
}
