<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookSessionRequest extends FormRequest
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
            'read_pages'=> 'required',
            'time'=> 'required',
            'date'=> 'required',
            'book_id' => 'required'
        ];
    }
}
