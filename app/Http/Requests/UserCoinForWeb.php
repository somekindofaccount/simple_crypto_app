<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserCoinForWeb extends FormRequest
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
        
        $method = ($this->method() == 'PATCH') ? 'PUT' : $this->method();
        
        switch($method)
        {
            case 'POST':
            {
                return [ 
                    'currency_id'=> 'required|integer',
                    'amount' => 'required',
                ];
            }
            default:break;
        }
        
    }
}
