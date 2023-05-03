<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'password' => 'required|min:8'
        ];
    }

    public function getCredentials()
    {
        $name = $this->get('name');

        if($this->isEmail($name)){
            return [
                'email' => $name,
                'password' => $this->get('password')
            ];
        }

        return $this->only('name', 'password');
    }

    public function isEmail($value)
    {
        $factory = $this->container->make(ValidationFactory::class);

        return !$factory->make(['name' => $value], ['name' => 'email'])->fails();
    }
}
