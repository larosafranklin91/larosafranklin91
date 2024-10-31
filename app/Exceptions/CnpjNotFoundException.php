<?php

namespace App\Exceptions;

use Exception;

class CnpjNotFoundException extends Exception
{
     protected $message = 'CNPJ não encontrado. Confirme o CNPJ e tente novamente.';
}
