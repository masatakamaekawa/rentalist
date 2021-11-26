<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = $this->route()->getName();
        $rule = [
            'title' => 'required|string|max:50',
            'body' => 'required|string|max:2000',
            'price' => 'required|string|max:50',
            // 'date' => 'required|string|max:50',
            'days' => 'required|string|max:50',
            'brand' => 'required|string|max:50',
            'area' => 'required|string|max:50',
            'category' => 'required|string|max:50',
            'delivery' => 'required|string|max:50',
        ];
        if ($route === 'rentals.store' ||
            ($route === 'rentals.update')) 
        return $rule;
    }
}
