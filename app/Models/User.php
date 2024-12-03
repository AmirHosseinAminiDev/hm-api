<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function pinnedQuestions()
    {
        return $this->belongsToMany(Question::class , 'user_pinned_questions');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function updateLevel()
    {
        $newLevel = Level::where('min_score', '<=', $this->score)
            ->orderBy('min_score', 'desc')
            ->first();

        if ($newLevel && $this->level_id !== $newLevel->id) {
            $this->level_id = $newLevel->id;
            $this->save();
        }
    }

    public function questionAnswerRecords()
    {
        return $this->belongsToMany(Question::class , 'user_correct_answer_records');
    }
}
