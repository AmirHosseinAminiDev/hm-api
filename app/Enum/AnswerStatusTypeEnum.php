<?php

namespace App\Enum;

enum AnswerStatusTypeEnum: string
{
    case CORRECT_ANSWER = 'correct';

    case INCORRECT_ANSWER = 'incorrect';
}
