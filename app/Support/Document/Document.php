<?php

namespace App\Support\Document;

class Document
{

    public function cnpj()
    {
        return new Cnpj();
    }

}
