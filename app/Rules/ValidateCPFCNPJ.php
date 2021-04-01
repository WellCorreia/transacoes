<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use \Bissolli\ValidadorCpfCnpj\CPF;
use \Bissolli\ValidadorCpfCnpj\CNPJ;

class ValidateCPFCNPJ implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cpf = new CPF($value);
        $cnpj = new CNPJ($value);
        return $cpf->isValid() || $cnpj->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The number of register cpf or cnpj have a error.';
    }
}
