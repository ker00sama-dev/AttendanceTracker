<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;

class CreateNewUser implements CreatesNewUsers
{
  use PasswordValidationRules;

  /**
   * Validate and create a newly registered user.
   *
   * @param array<string, string> $input
   */
  public function create(array $input): User
  {
    $input['phone_number'] = new PhoneNumber($input['phone_number'], 'EG');
    Validator::make($input, [
      'name' => [
        'required',
        'string',
        'max:255',
        'regex:/^(\S+\s+){3}\S+$/', // Ensures the name has exactly four words
      ],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'college_card_id' => ['required', 'integer', 'unique:users'],
      'department_id' => ['required', 'integer'],
      'college_year_id' => ['required', 'integer'],
      'phone_number' => ['required', new Phone($input['phone_number'], 'EG'), 'unique:users'], // Validate as an Egyptian phone number
      'password' => $this->passwordRules(),
      'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
    ])->validate();

    return User::create([
      'name' => $input['name'],
      'email' => $input['email'],
      'college_card_id' => $input['college_card_id'],
      'phone_number' => $input['phone_number'],
      'password' => Hash::make($input['password']),
    ]);
  }
}
