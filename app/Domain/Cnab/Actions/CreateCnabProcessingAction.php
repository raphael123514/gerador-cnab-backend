<?php

namespace App\Domain\Cnab\Actions;

use App\Domain\Cnab\Models\CNABProcessing;
use App\Domain\User\Models\User;

class CreateCnabProcessingAction
{
    /**
     * Cria um novo registro de processamento de CNAB.
     *
     * @param  User  $user  O usuário autenticado que está realizando o upload.
     * @param  array  $data  Dados validados da requisição.
     * @param  string  $filePath  O caminho onde o arquivo original foi salvo.
     */
    public function execute(User $user, array $data, string $filePath): CNABProcessing
    {
        return $user->cnabProcessings()->create([
            'fund_id' => $data['fund_id'],
            'file_sequence' => $data['file_sequence'],
            'original_filename' => $data['file_upload']->getClientOriginalName(),
            'original_filepath' => $filePath,
            'status' => 'pendente',
        ]);
    }
}
