<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjetoRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name'           => 'required|string|max:255',
			'sector'         => 'required|string|max:255',
			'description'    => 'nullable|string',
			'deadline_until' => 'nullable|date',
		];
	}
}
