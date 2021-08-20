<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // para os logs

class CategoryController extends Controller
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
        
        Log::channel('logs_loja')->info("Efetuada a exibição de todas as categorias. Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new Category;

        $categoria->categoria = $request->categoria;

        $result = $categoria->save();

        // Log de registro de operação:
        $user = auth()->user();
        
        Log::channel('logs_loja')->info("Efetuado o cadastro de uma categoria:\"$request->categoria\" Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        if($result){
            return ["result" => "Dados salvos com sucesso!"];
        }else{
            return ["result" => "Erro ao cadastrar"];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Category::findOrFail($id);

        // Log de registro de operação:
        $user = auth()->user();
        
        Log::channel('logs_loja')->info("Efetuada a exibição de uma categoria:\"$categoria->categoria\" Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        return $categoria;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categoria = Category::findOrFail($id);

        // Definindo o valor antigo e o novo da categoria antes da alteração para serem exibidos no log
        $old_cat = $categoria->categoria;
        $new_cat = $request->categoria;

        // Continuando a operação de update
        $categoria->categoria = $request->categoria;

        $result = $categoria->save();

        // Log de registro de operação:
        $user = auth()->user();
        
        Log::channel('logs_loja')->info("Efetuada a alteração de uma categoria: De \"$old_cat\" para \"$new_cat\". Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");
        
        if($result){
            return ["result" => "Dados salvos com sucesso!"];
        }else{
            return ["result" => "Erro ao alterar"];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Category::findOrFail($id);
        
        $result = $categoria->delete();

        // Log de registro de operação:
        $user = auth()->user();

        Log::channel('logs_loja')->info("Efetuada a exclusão de uma categoria:\"$categoria->categoria\" Usuário: ID=$user->id, NOME=$user->name, EMAIL=$user->email");

        if($result){
            return ["result" => "Dados deletados com sucesso!"];
        }else{
            return ["result" => "Erro ao deletar"];
        }
    }
}
