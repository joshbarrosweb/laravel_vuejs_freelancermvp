<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'city' => ['nullable','string', 'max:255'],
            'formation' => ['nullable','string', 'max:255'],
            'linkedin' => ['nullable','string', 'max:255'],
            'whatsapp' => ['nullable','string', 'max:255'],
            'skills' => ['nullable','string', 'max:255'],
            'cpf' => ['nullable', 'string', 'min:11', 'max:11', 'unique:users'],
            'cnpj' => ['nullable','string', 'min:14', 'max:14', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::firstOrCreate([
            'name' => $input['name'],
            'email' => $input['email'],
            'city' => $input['city'],
            'formation' => $input['formation'],
            'linkedin' => $input['linkedin'],
            'whatsapp' => $input['whatsapp'],
            'skills' => $input['skills'],
            'cpf' => $input['cpf'],
            'cnpj' => $input['cnpj'],
            'role_id' => $input['role_id'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
