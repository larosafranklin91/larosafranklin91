<?php

namespace App\Exceptions;

use Exception;

class CepNotFoundException extends Exception
{
     protected $message = 'CEP não encontrado. Confirme o CEP e tente novamente.';
}
