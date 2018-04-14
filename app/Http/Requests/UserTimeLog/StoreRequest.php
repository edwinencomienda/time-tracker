<?php

namespace App\Http\Requests\UserTimeLog;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:login,logout'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->user_id) {
                $user = User::find($this->user_id);
                if ($user->is_login && $this->type == 'login') {
                    $validator->errors()->add('user', 'user currently logged in.');
                }
                if (!$user->is_login && $this->type == 'logout') {
                    $validator->errors()->add('user', 'user currently logged out.');
                }
            }
        });
    }
}
