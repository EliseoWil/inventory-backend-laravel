<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //pasar a estado de false a true
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
            "name" => "required|unique:categories,name",
            "description" => "required|min:10"
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "El campo nombre es requerido",
            "description.required" => "El campo descripción es requerido",
            "description.min" => "El campo descripción debe contener como mínimo: 10 caracteres"
        ];  
    }
}
