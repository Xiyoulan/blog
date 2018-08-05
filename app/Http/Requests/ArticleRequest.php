<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required|min:2',
            'content_html' => 'required|min:10',
            'category_id' => 'required|numeric',
            'page_image' =>'mimes:jpeg,bmp,png,gif|dimensions:min_width=750,min_height=300',
        ];
    }

    public function messages()
    {
        return [
            'title.min' => '标题必须至少二个字符',
            'content_html.min' => '文章内容必须至少十个字符',
            'page_image.dimensions'=> '图片的宽度不得小于750px,高度不得小于300px',
        ];
    }

}
