<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use App\Article;

class ValidateArticles extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    /*public function authorize()
    {
        return true;
    }
    */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//		$article = Article::find($this->articles);
        return [
            'name' => 'required|unique:articles,name,' .\Request::instance()->id,
            'body' => 'required|min:5',
        ];
    }
}
