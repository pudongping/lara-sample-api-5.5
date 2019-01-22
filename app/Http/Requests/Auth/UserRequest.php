<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class UserRequest extends Request
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

    public function messages()
    {

        $messages = [
            'name.unique' => '该账号已存在',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'postAdd' => [
                'name' => 'required|string|max:255|unique:users',
                'phone' => 'required|string|size:11|unique:users',
//                'identity_id' => 'required|int|exists:users_identities,id',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?![A-Z]+$)(?![a-z]+$)(?!\d+$)(?![\W_]+$)\S{8,32}$/i',
                ],
            ],
            'getEdit' => [
                'id' => 'required|integer|min:1'
            ],
        ];

        return $this->useRule($rules);

    }



}
