<?php

namespace App\Http\Requests\Post;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $invalidParams = $validator->errors()->toArray();
        $currentParams = $this->query();

        // Удалить из текущих параметров неправильные
        foreach ($invalidParams as $key => $value) {
            unset($currentParams[$key]);
        }

        // Если остались правильные параметры в текущих - добавить "?"
        $currentParamsString = count($currentParams) === 0 ? ""
            : "?" . http_build_query($currentParams);

        $newUrl = url()->current() . $currentParamsString;

        throw new HttpResponseException(redirect($newUrl)->withInput());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "category_id" => "nullable|integer|exists:categories,id",
            "is_published" => "nullable|boolean",
        ];
    }
}
