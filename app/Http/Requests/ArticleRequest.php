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
            'title' =>  'required|string|between:1,100',
            'px'    =>  'required|integer|between:0,255',
            'remark'=>  'string|max:200',
            'auther'=>  'string|between:1,30',
            'from'  =>  'string|between:1,100',
            'browse'=>  'required|integer|min:0',
            'content'=> 'required',
            //'cover' =>  'image|max:500',
        ];
    }
}
