<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class AdvertRequest extends FormRequest
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
     * @return array
     */
    #[ArrayShape(['name' => "string[]", 'from' => "string[]", 'to' => "string[]", 'total_budget' => "string[]", 'daily_budget' => "string[]", "banners" => "string[]", 'banners.*' => "string[]", 'user_id' => "array", 'id' => "array"])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'from' =>  ['required', 'date', 'before:to'],
            'to' =>  ['required', 'date', 'after:from'],
            'total_budget' => ['required', 'numeric'],
            'daily_budget' => ['required', 'numeric'],
            "banners" => ['required', 'array'],
            'banners.*' => ['image', 'mimes:jpg,jpeg,png', 'max:10000'],
            'user_id' => ['required', 'numeric'],
            'id' => ['filled', 'numeric'],
        ];
    }
}
