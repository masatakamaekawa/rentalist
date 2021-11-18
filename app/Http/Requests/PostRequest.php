<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'days' => 'required|string|max:50',
            'brand' => 'required|string|max:50',
            'area' => 'required|string|max:50',
            'category' => 'required|string|max:50',
            'delivery' => 'required|string|max:50',

        ];

        if ($route === 'posts.store' ||
            ($route === 'posts.update' && $this->file('image'))) {
            $rule['image'] = 'required|file|image|mimes:jpeg,png';
        }
        return $rule;
    }
}
