<?php

namespace App\Services;

use App\Models\Answer;

class AnswerService
{

    /**
     * @param $data
     * @return mixed
     */
    public function create($data): mixed
    {
        return Answer::create($data);
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
