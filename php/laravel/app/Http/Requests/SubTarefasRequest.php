<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubTarefasRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
            'task_id' => 'nullable',
        ];
    }
}
