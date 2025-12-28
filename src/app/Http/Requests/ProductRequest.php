<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'price' => 'required|numeric|min:0|max:10000',
            'season_ids' => 'required|exists:seasons,id',
            'description' => 'required|max:120',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|mimes:png,jpeg';
        } else {
            $rules['image'] = 'nullable|mimes:png,jpeg';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0∼10000円以内で入力してください',
            'price.max' => '0∼10000円以内で入力してください',
            'image.required' => '画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'season_ids.required' => '季節を選択してください',
            'season_ids.exists' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ];
    }
}
