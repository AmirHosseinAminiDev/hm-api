<?php

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Enum\AnswerStatusTypeEnum as ANSWERSTATUSTYPE;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_correct_answer_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::Class);
            $table->foreignIdFor(Question::Class);
            $table->enum('answer_type', [ANSWERSTATUSTYPE::CORRECT_ANSWER->value, ANSWERSTATUSTYPE::INCORRECT_ANSWER->value])->default(ANSWERSTATUSTYPE::CORRECT_ANSWER->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_correct_answer_records');
    }
};
