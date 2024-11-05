<?php

namespace App\Http\Integrations\BrasilApi\DTO;

readonly class CompanyDTO
{
    public function __construct(
        public string     $cnpj,
        public string|int $branchIdentifier,
        public string     $branchDescription,
        public string     $corporateName,
        public string     $tradeName,
        public int        $registrationStatus,
        public string     $registrationStatusDescription,
        public string     $registrationStatusDate,
        public int        $registrationStatusReason,
        public string     $foreignCityName,
        public int        $legalNatureCode,
        public string     $activityStartDate,
        public int        $fiscalCnae,
        public string     $fiscalCnaeDescription,
        public string     $addressTypeDescription,
        public string     $address,
        public string     $number,
        public string     $complement,
        public string     $neighborhood,
        public int        $zipCode,
        public string     $state,
        public int        $cityCode,
        public string     $city,
        public string     $phone1,
        public string     $phone2,
        public string     $fax,
        public int        $responsibleQualification,
        public float      $capital,
        public int|string $size,
        public string     $sizeDescription,
        public bool       $simpleOption,
        public string     $simpleOptionDate,
        public string     $simpleExclusionDate,
        public bool       $meiOption,
        public string     $specialStatus,
        public string     $specialStatusDate,


    )
    {
    }

    public static function fromArray(array $attributes): self
    {
        // dd($attributes);
        // considerando que os dados virão como comentados acima, gere uma transformação deles para o DTO
        return new self(
            cnpj: $attributes['cnpj'],
            branchIdentifier: $attributes['descricao_identificador_matriz_filial'] ?? '',
            branchDescription: $attributes['descricao_identificador_matriz_filial'] ?? '',
            corporateName: $attributes['razao_social'],
            tradeName: $attributes['nome_fantasia'],
            registrationStatus: $attributes['situacao_cadastral'],
            registrationStatusDescription: $attributes['descricao_situacao_cadastral'],
            registrationStatusDate: $attributes['data_situacao_cadastral'],
            registrationStatusReason: $attributes['motivo_situacao_cadastral'],
            foreignCityName: $attributes['nome_cidade_exterior'] ?? '',
            legalNatureCode: $attributes['codigo_natureza_juridica'],
            activityStartDate: $attributes['data_inicio_atividade'],
            fiscalCnae: $attributes['cnae_fiscal'],
            fiscalCnaeDescription: $attributes['cnae_fiscal_descricao'],
            addressTypeDescription: $attributes['descricao_tipo_de_logradouro'],
            address: $attributes['logradouro'],
            number: $attributes['numero'],
            complement: $attributes['complemento'],
            neighborhood: $attributes['bairro'],
            zipCode: $attributes['cep'],
            state: $attributes['uf'],
            cityCode: $attributes['codigo_municipio'],
            city: $attributes['municipio'],
            phone1: $attributes['ddd_telefone_1'],
            phone2: $attributes['ddd_telefone_2'],
            fax: $attributes['ddd_fax'],
            responsibleQualification: $attributes['qualificacao_do_responsavel'],
            capital: $attributes['capital_social'],
            size: $attributes['porte'],
            sizeDescription: $attributes['descricao_porte'],
            simpleOption: $attributes['opcao_pelo_simples'] ?? false,
            simpleOptionDate: $attributes['data_opcao_pelo_simples'] ?? '',
            simpleExclusionDate: $attributes['data_exclusao_do_simples'] ?? '',
            meiOption: $attributes['opcao_pelo_mei'] ?? false,
            specialStatus: $attributes['situacao_especial'] ?? '',
            specialStatusDate: $attributes['data_situacao_especial'] ?? '',
        );
    }

    public function isActive(): bool
    {
        return $this->registrationStatus === 2;
    }

    public function toArray(): array
    {

        return [
            'cnpj' => $this->cnpj,
            'branchIdentifier' => $this->branchIdentifier,
            'branchDescription' => $this->branchDescription,
            'corporateName' => $this->corporateName,
            'tradeName' => $this->tradeName,
            'registrationStatus' => $this->registrationStatus,
            'registrationStatusDescription' => $this->registrationStatusDescription,
            'registrationStatusDate' => $this->registrationStatusDate,
            'registrationStatusReason' => $this->registrationStatusReason,
            'foreignCityName' => $this->foreignCityName,
            'legalNatureCode' => $this->legalNatureCode,
            'activityStartDate' => $this->activityStartDate,
            'fiscalCnae' => $this->fiscalCnae,
            'fiscalCnaeDescription' => $this->fiscalCnaeDescription,
            'addressTypeDescription' => $this->addressTypeDescription,
            'address' => $this->address,
            'number' => $this->number,
            'complement' => $this->complement,
            'neighborhood' => $this->neighborhood,
            'zipCode' => $this->zipCode,
            'state' => $this->state,
            'cityCode' => $this->cityCode,
            'city' => $this->city,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'fax' => $this->fax,
            'responsibleQualification' => $this->responsibleQualification,
            'capital' => $this->capital,
            'size' => $this->size,
            'sizeDescription' => $this->sizeDescription,
            'simpleOption' => $this->simpleOption,
            'simpleOptionDate' => $this->simpleOptionDate,
            'simpleExclusionDate' => $this->simpleExclusionDate,
            'meiOption' => $this->meiOption,
            'specialStatus' => $this->specialStatus,
            'specialStatusDate' => $this->specialStatusDate,
        ];
    }
}
