<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'question_id' => 'required|integer|exists:questions,id',
            'content' => 'required|string|max:255',
            'is_accepted' => 'required|boolean',
//            'is_correct_answer' => 'required|boolean',

        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'شناسه کاربر الزامی است.',
            'user_id.integer' => 'شناسه کاربر باید یک عدد صحیح باشد.',
            'user_id.exists' => 'کاربر مورد نظر یافت نشد.',

            'question_id.required' => 'شناسه سوال الزامی است.',
            'question_id.integer' => 'شناسه سوال باید یک عدد صحیح باشد.',
            'question_id.exists' => 'سوال مورد نظر یافت نشد.',

            'content.required' => 'وارد کردن محتوا الزامی است.',
            'content.string' => 'محتوا باید به صورت یک متن باشد.',
            'content.max' => 'محتوا نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'is_accepted.required' => 'وضعیت پذیرش باید مشخص شود.',
            'is_accepted.boolean' => 'وضعیت پذیرش باید یک مقدار بولی باشد.',

            'is_correct_answer.required' => 'وضعیت پاسخ درست باید مشخص شود.',
            'is_correct_answer.boolean' => 'وضعیت پاسخ درست باید یک مقدار بولی باشد.',
        ];
    }

}
