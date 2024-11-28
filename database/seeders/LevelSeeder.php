<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['name' => 'تازه وارد', 'min_score' => 0, 'slug' => 'L0'],
            ['name' => 'شهروند', 'min_score' => 10, 'slug' => 'L1'],
            ['name' => 'خبرنگار', 'min_score' => 990, 'slug' => 'L2'],
            ['name' => 'مشارکت‌کننده', 'min_score' => 3000, 'slug' => 'L3'],
            ['name' => 'توسعه‌دهنده', 'min_score' => 8000, 'slug' => 'L4'],
            ['name' => 'بازرس', 'min_score' => 18000, 'slug' => 'L5'],
            ['name' => 'تاجر', 'min_score' => 36000, 'slug' => 'L6'],
            ['name' => 'وکیل', 'min_score' => 76000, 'slug' => 'L7'],
            ['name' => 'شورای شهر', 'min_score' => 166000, 'slug' => 'L8'],
            ['name' => 'شهردار', 'min_score' => 366000, 'slug' => 'L9'],
            ['name' => 'فرماندار', 'min_score' => 796000, 'slug' => 'L10'],
            ['name' => 'وزیر', 'min_score' => 1696000, 'slug' => 'L11'],
            ['name' => 'قاضی', 'min_score' => 3696000, 'slug' => 'L12'],
            ['name' => 'قانون‌گذار', 'min_score' => 7896000, 'slug' => 'L13'],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
