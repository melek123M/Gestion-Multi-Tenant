<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AssignTaskAPIRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'user_id' => 'required|exists:users,id',
    ];
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages(): array
  {
    return [
      'user_id.required' => 'The user ID is required to assign the task.',
      'user_id.exists' => 'The selected user does not exist.',
    ];
  }
}