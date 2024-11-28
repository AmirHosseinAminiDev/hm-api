<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string|in:answer,comment,question',
            'content' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'فیلد کاربر اجباری است.',
            'user_id.integer' => 'فیلد کاربر باید یک عدد صحیح باشد.',
            'user_id.exists' => 'کاربر انتخاب شده وجود ندارد.',

            'commentable_id.required' => 'فیلد شناسه قابل کامنت اجباری است.',
            'commentable_id.integer' => 'فیلد شناسه قابل کامنت باید یک عدد صحیح باشد.',

            'commentable_type.required' => 'فیلد نوع قابل کامنت اجباری است.',
            'commentable_type.string' => 'فیلد نوع قابل کامنت باید یک رشته باشد.',
            'commentable_type.in' => 'نوع  کامنت باید یکی از مقادیر "پاسخ"، "کامنت" یا "سوال" باشد.',

            'content.required' => 'فیلد محتوا اجباری است.',
            'content.string' => 'فیلد محتوا باید یک رشته باشد.',
            'content.max' => 'فیلد محتوا نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        ];
    }

    public function getUserId()
    {
        return $this->get('user_id');
    }

    public function getCommentableType()
    {
        return $this->get('commentable_type');
    }

    public function getCommentableId()
    {
        return $this->get('commentable_id');
    }

    public function getCommentContent()
    {
        return $this->get('content');
    }
}
