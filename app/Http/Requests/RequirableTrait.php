<?php

namespace App\Http\Requests;

namespace App\Http\Requests;

/**
 * RequirableTrait
 * Com este trait, é possível definir se um campo é obrigatório ou não, dependendo do método HTTP da requisição.
 * Seu uso facilita a validação de dados nas requisições HTTP para Criar e Atualizar registros.
 */
trait RequirableTrait
{
    /**
     * @return bool
     */
    private function isUpdating():bool
    {
        return in_array($this->method(), ['PUT', 'PATCH']);
    }

    /**
     * @return string
     */
    private function requirable():string
    {
        return $this->isUpdating() ? 'filled' : 'required';
    }

    /**
     * @return string
     */
    private function nullable():string
    {
        return $this->isUpdating() ? 'filled' : 'nullable';
    }
}
