<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskAPIRequest extends FormRequest
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
      'name' => 'sometimes|string|max:255',
      'description' => 'sometimes|string',
      'status' => 'sometimes|in:pending,in_progress,completed',
      'due_date' => 'sometimes|date',
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
      'name.string' => 'The task name must be a string.',
      'name.max' => 'The task name cannot exceed 255 characters.',
      'description.string' => 'The task description must be a string.',
      'status.in' => 'The task status must be one of: pending, in_progress, or completed.',
      'due_date.date' => 'The due date must be a valid date format.',
    ];
  }
}