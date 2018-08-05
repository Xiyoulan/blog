<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|min:1',
            'article_id' => 'required|numeric|exists:articles,id',
            'parant_id' => 'nullable|numeric|exists:replies,id',
            'reply_to_id' => 'nullable|numeric|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'article_id.exists' => '回复的话题不存在',
            'parant_id.exists' => '回复的对象不存在',
            'reply_to_id.exists' => '回复的对象不存在',
        ];
    }

}
