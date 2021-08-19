<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;

class JsonResponseMiddleware
{
    protected $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // Fazendo um "preset" para que o usuário da API não precise sempre inserir os dados abaixo no postman
        $request->headers->set("Accept", "application/json");

        $response = $next($request);

        // se a resposta não for Json, será convertida
        if(! $response instanceof JsonResponse){
            $response = $this->responseFactory->json(
                $response->content(),
                $response->status(),
                $response->headers->all()
            );
        }
        return $response;
    }
}