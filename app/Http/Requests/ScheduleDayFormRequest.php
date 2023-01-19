<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\AbstractFormRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ScheduleDayFormRequest extends AbstractFormRequest
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
            if ($actionName == 'assginDayToSchedule') {
                return [
                    'day_id'               => 'required|integer|exists:days,id',
                    'time_from'            => 'required|date_format:H:i',
                    'time_to'              => 'required|date_format:H:i|after:time_from',
                    // 'user_id'              => 'required|integer|exists:users,id',
                ];
            } elseif ($actionName == 'deleteDayToSchedule') {
                return [
                    'day_id'               => 'required|integer|exists:days,id',
                ];
            }
        }
    }
}
