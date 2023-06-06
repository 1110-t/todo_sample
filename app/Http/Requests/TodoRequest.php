<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'item_name'=>'required|max:100',
            'user_id'=>'required|exists:users,id',
            'expire_date'=>'required|date_format:Y-m-d',
            'finished_date'=>'in:0,1',
        ];
    }
}
