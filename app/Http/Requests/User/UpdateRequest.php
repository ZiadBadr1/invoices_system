<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = $this->route('user')->id; // Getting the user ID from the route model binding

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|same:confirm-password',
            'roles_name' => 'required|array',
            'status' => 'required|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
