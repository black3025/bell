<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:255'],
            'username' => ['username', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'first_name' => ['string', 'max:255'],
            'middle_name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
        ];
    }
}
