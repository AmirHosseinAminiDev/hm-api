<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Level;

class UpdateUserLevels extends Command
{
    protected $signature = 'users:update-levels';
    protected $description = 'به‌روزرسانی سطح کاربران با توجه به امتیازاتشان';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $newLevel = Level::where('min_score', '<=', $user->score)
                ->orderBy('min_score', 'desc')
                ->first();

            if ($newLevel && $user->level_id !== $newLevel->id) {
                $user->level_id = $newLevel->id;
                $user->save();

                $this->info("سطح کاربر {$user->name} به {$newLevel->name} تغییر کرد.");
            }
        }

        $this->info('سطوح کاربران با موفقیت به‌روزرسانی شد!');
    }
}
