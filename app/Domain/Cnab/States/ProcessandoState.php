<?php

namespace App\Domain\Cnab\States;

use App\Domain\Cnab\Enums\ProcessingStatus;
use App\Domain\Cnab\Exceptions\InvalidStateException;
use App\Domain\Cnab\Models\CNABProcessing;

class ProcessandoState
{
    public function start(CNABProcessing $processing): void
    {
        throw new InvalidStateException('O processamento já foi iniciado.');
    }

    public function complete(CnabProcessing $processing, string $cnabFilePath): void
    {
        $processing->status = ProcessingStatus::CONCLUIDO;
        $processing->cnab_filepath = $cnabFilePath;
        $processing->save();
    }

    public function fail(CnabProcessing $processing, string $errorMessage): void
    {
        $processing->status = ProcessingStatus::ERRO;
        $processing->save();
    }
}
