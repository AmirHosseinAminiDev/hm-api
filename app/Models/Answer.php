<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class Answer extends Model
{
    protected $table = 'answers';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->old_question_id = 0;
            $post->old_answer_id = 0;
        });
    }

    /**
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return MorphMany
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function likesCount()
    {
        return $this->votes()->where('vote_type', 1)->count();
    }

    public function dislikesCount()
    {
        return $this->votes()->where('vote_type', 0)->count();
    }

    public function getAnswerComments()
    {
        return DB::table('comments')
            ->where('commentable_type','App\\Models\\Comment')
            ->where('commentable_id',$this->id)->get();
    }
}
