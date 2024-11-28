<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'publish_question',
            'publish_answer',
            'publish_comment',
            'publish_comments',
            'publish_answers',
            'publish_questions',
            'pin_question',
            'unpin_question',
            'accept_correct_answer',
            'change_correct_answer_status',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
