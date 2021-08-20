<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'nome' => 'required',
            'preco' => 'required',
            'composicao' => 'required',
            'tamanho' => 'required',
            'quantidade' => 'required',
            'category_id' => 'required',
            'imagens.*' => 'mimes:jpg,jpeg|max:5000',
            'imagens' => 'max:3',
        ];

    }

    public function messages(){
        return $messages = [ 
            'nome.required' => 'O nome é obrigatório',
            'preco.required' => 'O preço é obrigatório',
            'composicao.required' => 'A composição é obrigatória',
            'tamanho.required' => 'O tamanho é obrigatório',
            'quantidade.required' => 'O quantidade é obrigatória',
            'category_id.required' => 'A categoria é obrigatória',
            'mimes' => 'Permitidas imagens apenas de formato .jpg ou .jpeg',
            'max' => 'Máximo máximo permitido de imagens: 3'
        ];
    } 
}
