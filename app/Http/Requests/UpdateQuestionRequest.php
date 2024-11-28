<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'tags' => 'array|nullable',
            'tags.*' => 'exists:tags,id',
            'user_id' => 'required|exists:users,id',
            'is_pinned' => 'required|boolean',
            'status' => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'وارد کردن عنوان سوال الزامی است.',
            'title.string' => 'عنوان سوال باید به صورت متن باشد.',
            'title.max' => 'عنوان سوال نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'category_id.required' => 'انتخاب دسته‌بندی سوال الزامی است.',
            'category_id.exists' => 'دسته‌بندی انتخاب شده معتبر نمی‌باشد.',

            'content.required' => 'متن سوال را وارد کنید.',
            'content.string' => 'متن سوال باید به صورت متن باشد.',

            'tags.array' => 'تگ‌ها باید به صورت آرایه ارسال شوند.',
            'tags.*.exists' => 'تگ انتخاب شده معتبر نمی‌باشد.',
        ];
    }

}
