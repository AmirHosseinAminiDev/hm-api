<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVoteRequest extends FormRequest
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
            'vote_type' => 'required|boolean',
            'vote_model' => 'required|string|in:answer,comment,question',
            'vote_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'وارد کردن شناسه کاربر الزامی است.',
            'user_id.integer' => 'شناسه کاربر باید یک عدد صحیح باشد.',
            'user_id.exists' => 'کاربر انتخاب شده معتبر نمی‌باشد.',

            'vote_type.required' => 'وارد کردن نوع رأی الزامی است.',
            'vote_type.boolean' => 'نوع رأی باید مقدار صحیح (صفر یا یک) باشد.',

            'vote_model.required' => 'انتخاب مدل رأی الزامی است.',
            'vote_model.string' => 'مدل رأی باید به صورت رشته باشد.',
            'vote_model.in' => 'مدل رأی باید یکی از مقادیر answer، comment یا question باشد.',

            'vote_id.required' => 'وارد کردن شناسه رأی الزامی است.',
            'vote_id.integer' => 'شناسه رأی باید یک عدد صحیح باشد.',
        ];
    }


    public function getUserId()
    {
        return $this->get('user_id');
    }

    public function getVoteType()
    {
        return $this->get('vote_type');
    }

    public function getVoteModel()
    {
        return $this->get('vote_model');
    }

    public function getVoteId()
    {
        return $this->get('vote_id');
    }
}
