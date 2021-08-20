<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produto = new Product;

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->composicao = $request->composicao;
        $produto->tamanho = $request->tamanho;
        $produto->quantidade = $request->quantidade;
        $produto->category_id = $request->category_id;
        
        // Salvando a imagem
        /* $produto->imagens = $request->file('imagens'); */
        
        if($request->hasFile('imagens')) {

            $imagens = $request->imagens;

            // Esse array abrigará as imagens no final do loop
            $imagensParaInserir = [];

            // Tratando cada imagem(As validações estão em "App\Http\Requests\ProductRequest")
            foreach($imagens as $imagem){

                // fazendo um nome único e concatenando com a extensão
                $nome_imagem = md5($imagem->getClientOriginalName()) . strtotime('now') . "." . $imagem->extension();

                // Salvando em uma pasta
                $imagem->move(public_path('imagens'), $nome_imagem);

                array_push($imagensParaInserir, $nome_imagem);
            }

            //return response()->json([$imagensParaInserir]);

            // Se ocorreu tudo certo
            //return response()->json(['Imagens inseridas com sucesso']);
        }

        $result = $produto->save();
        if($result){
            return ["result" => "Dados salvos com sucesso!"];
        }else{
            return ["result" => "Erro ao cadastrar"];
        }
    }
    
    public function teste_upload(ProductRequest $request){

        $imagens = $request->file('imagens');
        
        if($request->hasFile('imagens')) {

            // Tratando cada imagem(As validações estão em "App\Http\Requests\ProductRequest")
            foreach($imagens as $imagem){

                // fazendo um nome único e concatenando com a extensão
                $nome_imagem = md5($imagem->getClientOriginalName()) . strtotime('now') . "." . $imagem->extension();

                // Salvando em uma pasta
                $imagem->move(public_path('imagens'), $nome_imagem);
            }

            // Se ocorreu tudo certo
            return response()->json(['Imagens inseridas com sucesso']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
