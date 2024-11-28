<?php

namespace Database\Seeders;

use App\Enum\LevelEnum;
use App\Models\Level;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // publish question permission
        DB::table('level_permissions')->truncate();
        $permission = Permission::where('name', 'publish_question')->first();
        $levelsList = LevelEnum::getLevelEnumList();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            if ($level->slug == 'L1' || $level->slug == 'L0') {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 0,
                ]);
            } else {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 1,
                ]);
            }
        }


        // publish answer permission
        $permission = Permission::where('name', 'publish_answer')->first();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            DB::table('level_permissions')->insert([
                'level_id' => $level->id,
                'permission_id' => $permission->id,
                'status' => 0,
            ]);

        }


        // publish comment permission
        $permission = Permission::where('name', 'publish_comment')->first();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            if ($level->slug == 'L1' || $level->slug == 'L0') {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 0,
                ]);
            } else {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 1,
                ]);
            }
        }


        //publish_comments permission
        $permission = Permission::where('name', 'publish_comments')->first();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            if ($level->slug == 'L1' || $level->slug == 'L0' || $level->slug == 'L2') {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 0,
                ]);
            } else {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 1,
                ]);
            }
        }


        //publish_questions permission
        $permission = Permission::where('name', 'publish_questions')->first();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            if ($level->slug == 'L1' || $level->slug == 'L0' || $level->slug == 'L2') {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 0,
                ]);
            } else {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 1,
                ]);
            }
        }


        //publish_answers permission
        $permission = Permission::where('name', 'publish_answers')->first();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            if ($level->slug == 'L1' || $level->slug == 'L0' || $level->slug == 'L2') {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 0,
                ]);
            } else {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 1,
                ]);
            }
        }


        //unpin_question permission
        $permission = Permission::where('name', 'unpin_question')->first();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            if ($level->slug == 'L1' || $level->slug == 'L0' || $level->slug == 'L2' || $level->slug == 'L3' || $level->slug == 'L4') {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 0,
                ]);
            } else {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 1,
                ]);
            }
        }


        //accept_correct_answer permission
        $permission = Permission::where('name', 'accept_correct_answer')->first();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            if ($level->slug == 'L1' || $level->slug == 'L0' || $level->slug == 'L2' || $level->slug == 'L3') {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 0,
                ]);
            } else {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 1,
                ]);
            }
        }












        //change_correct_answer_status permission
        $permission = Permission::where('name', 'change_correct_answer_status')->first();
        foreach ($levelsList as $name => $value) {
            $level = Level::where('slug', 'L' . $value)->first();
            if ($level->slug == 'L1' || $level->slug == 'L0' || $level->slug == 'L2' || $level->slug == 'L3'|| $level->slug == 'L4') {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 0,
                ]);
            } else {
                DB::table('level_permissions')->insert([
                    'level_id' => $level->id,
                    'permission_id' => $permission->id,
                    'status' => 1,
                ]);
            }
        }


        $levels = Level::with('permissions')->get();
        foreach ($levels as $level) {
            foreach ($level->permissions as $permission)
            {
                echo "Level Name: {$level->name}" . PHP_EOL;
                echo "Permission Name: {$permission->name}" . PHP_EOL;
                echo "Status: {$permission->pivot->status}" . PHP_EOL;
                echo str_repeat("-", 40) . PHP_EOL;
            }
        }

    }
}
