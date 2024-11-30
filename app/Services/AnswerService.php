<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;

class AnswerService
{

    /**
     * @param $data
     * @return mixed
     */
    public function create($data): mixed
    {

        $answer = Answer::create($data);


        $question = Question::where('id', $answer->question_id)
            ->with(['activity', 'category'])->first();
        $question->activity()->update([
            'last_activity' => now()
        ]);
        $question->category->activity()->update([
            'last_activity' => now()
        ]);
        return $answer;
    }

    /**
     * @param $answerId
     * @param $data
     * @return mixed
     */
    public function update($answerId, $data): mixed
    {
        $answer = Answer::where('id', $answerId)->first();
        $answer->update($data);

        $question = Question::where('id', $answer->question_id)
            ->with(['activity' , 'category'])->first();
        $question->activity()->update([
            'last_activity' => now()
        ]);
        $question->category->activity()->update([
            'last_activity' => now()
        ]);

        return $answer;
    }

    /**
     * @param $id
     * @return true
     */
    public function delete($id): true
    {
        Answer::where('id', $id)->delete();
        return true;
    }
}
