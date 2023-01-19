<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\AbstractFormRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserFormRequest extends AbstractFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request, User $user)
    {


        $action = $request->route()->getActionName();
        $actionName = trim(strstr($action, '@'), '@');
        $method = $request->getMethod();
        if ($method == 'POST') {
            if ($actionName == 'register') {
                return [
                    'user_name' => 'required|string|max:255|unique:users',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8',
                ];
            } elseif ($actionName == 'login') {
                return [
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                ];
            }
        }
    }
}
