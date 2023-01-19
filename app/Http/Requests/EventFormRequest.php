<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\AbstractFormRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EventFormRequest extends AbstractFormRequest
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
            if ($actionName == 'store') {
                return [
                    'name'                => 'required|string|max:255',
                    'description'         => 'required|string',
                    'slug'                => 'required|string|max:255|unique:events',
                    'duration'            => 'required',
                    'time_between'        => 'sometimes|required',
                    'schedule_id'         => 'required|integer|exists:schedules,id',
                    'user_id'             => 'required|integer|exists:users,id',
                ];
            }
        } else if ($method == 'PUT') {
            if ($actionName == 'update') {
                return [
                    'name'                => 'sometimes|required|string|max:255',
                    'description'         => 'sometimes|required|string',
                    'slug'                => 'sometimes|required|string|max:255|unique:events',
                    'duration'            => 'sometimes|required',
                    'time_between'        => 'sometimes|required',
                    'schedule_id'         => 'required|integer|exists:schedules,id',
                ];
            }
        }
    }
}
