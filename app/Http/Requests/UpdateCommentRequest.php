<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'content' => 'required|string',
            'status' => 'nullable|boolean',
        ];
    }

    public function getCommentId()
    {
        return $this->get('comment_id');
    }

    public function getUserId()
    {
        return $this->get('user_id');
    }

    public function getCommentContent()
    {
        return $this->get('content');
    }

    public function getCommentStatus()
    {
        return $this->get('status') ?? null;
    }
}
