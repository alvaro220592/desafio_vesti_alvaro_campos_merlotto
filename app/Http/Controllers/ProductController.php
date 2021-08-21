<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Log; // para os logs

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Log de registro de operação:
        $user = auth()->user();
        
        Log::channel('logs_loja')->info("Efetuada a exibição dos produtos. Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $produto = new Product;

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->composicao = $request->composicao;
        $produto->tamanho = $request->tamanho;
        $produto->quantidade = $request->quantidade;
        $produto->category_id = $request->category_id;
        
        // Salvando a imagem        
        if($request->hasFile('imagens')) {

            $imagens = $request->imagens;

            // Esse array abrigará as imagens no final do loop
            $imagensParaInserir = [];

            // Tratando cada imagem(As validações estão em "App\Http\Requests\ProductRequest")
            foreach($imagens as $imagem){

                // fazendo um nome único e concatenando com a extensão
                $nome_imagem = rand(0, 5000).strtotime('now') . "." . $imagem->extension();

                // Salvando em uma pasta
                $imagem->move(public_path('imagens'), $nome_imagem);

                // Inserindo a imagem atual no array criado acima
                array_push($imagensParaInserir, $nome_imagem);
            }

            // definindo as imagens que irão para o banco de dados
            $produto->imagens = $imagensParaInserir;
        }

        // Log de registro de operação:
        $user = auth()->user();
        
        Log::channel('logs_loja')->info("Efetuado o cadastro de um produto:NOME=\"$request->nome\", PREÇO=\"$request->preco\", COMPOSIÇÃO=\"$request->composicao\", TAMANHO=\"$request->tamanho\", QUANTIDADE=\"$request->quantidade\". Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        $result = $produto->save();
        if($result){
            return ["result" => "Dados salvos com sucesso!"];
        }else{
            return ["result" => "Erro ao cadastrar"];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = Product::findOrFail($id);
        
        // Log de registro de operação:
        $user = auth()->user();
        
        Log::channel('logs_loja')->info("Efetuada a exibição de um produto:NOME=\"$produto->nome\", PREÇO=\"$produto->preco\", COMPOSIÇÃO=\"$produto->composicao\", TAMANHO=\"$produto->tamanho\", QUANTIDADE=\"$produto->quantidade\". Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        return $produto;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $produto = Product::findOrFail($id);

        $old_nome = $produto->nome;
        $old_preco = $produto->preco;
        $old_composicao = $produto->composicao;
        $old_tamanho = $produto->tamanho;
        $old_quantidade = $produto->quantidade;
        $old_category_id = $produto->category_id;

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->composicao = $request->composicao;
        $produto->tamanho = $request->tamanho;
        $produto->quantidade = $request->quantidade;
        $produto->category_id = $request->category_id;

        // Salvando a imagem        
        if($request->hasFile('imagens')) {

            $imagens = $request->imagens;

            // Esse array abrigará as imagens no final do loop
            $imagensParaInserir = [];

            // Tratando cada imagem(As validações estão em "App\Http\Requests\ProductRequest")
            foreach($imagens as $imagem){

                // fazendo um nome único e concatenando com a extensão
                $nome_imagem = rand(0, 5000).strtotime('now') . "." . $imagem->extension();

                // Salvando em uma pasta
                $imagem->move(public_path('imagens'), $nome_imagem);

                // Inserindo a imagem atual no array criado acima
                array_push($imagensParaInserir, $nome_imagem);
            }

            // definindo as imagens que irão para o banco de dados
            $produto->imagens = $imagensParaInserir;
        }
        

        //$produto->save()->request->all();
        $result = $produto->save();

        // Log de registro de operação:
        $user = auth()->user();
        
        Log::channel('logs_loja')->info("Efetuada a alteração de um produto:NOME=de \"$old_nome\" para \"$request->nome\", PREÇO=de \"$old_preco\" para \"$request->preco\", COMPOSIÇÃO=de \"$old_composicao\" para \"$request->composicao\", TAMANHO=de \"$old_tamanho\" para \"$request->tamanho\", QUANTIDADE=de \"$old_quantidade\" para \"$request->quantidade\", CATEGORIA=de \"$old_category_id\" para \"$request->category_id\". Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        if($result){
            return ["result" => "Dados salvos com sucesso!"];
        }else{
            return ["result" => "Erro ao alterar"];
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Product::findOrFail($id);

        $result = $produto->delete();

        // Log de registro de operação:
        $user = auth()->user();
        
        Log::channel('logs_loja')->info("Efetuada a exclusão do produto:NOME=\"$produto->nome\",PRECO=\"$produto->preco\",COMPOSIÇÃO=\"$produto->composicao\",TAMANHO=\"$produto->tamanho\",QUANTIDADE=\"$produto->quantidade\". Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        if($result){
            return ["result" => "Dados excluídos com sucesso!"];
        }else{
            return ["result" => "Erro ao excluir"];
        }
    }
}
