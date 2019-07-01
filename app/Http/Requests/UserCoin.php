<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserCoin extends FormRequest
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
                    'currency_name' => 'required',
                    'usd_rate' => 'required',
                    'amount' => 'required',
                ];
            }
            default:break;
        }
        
    }
}
