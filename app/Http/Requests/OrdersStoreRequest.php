<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdersStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_name' => 'string|required',
            'client_phone' => 'string|size:11|required|unique:orders,client_phone',
            'tariff_id' => 'integer|required|exists:tariffs,id',
            'schedule_type' => 'in:EVERY_DAY,EVERY_OTHER_DAY,EVERY_OTHER_DAY_TWICE|required',
            'comment' => 'string|required',
            'first_date' => 'date|required',
            'last_date' => 'date|required',
        ];
    }
}
