<?php

namespace App\Domain\Cnab\States;

use App\Domain\Cnab\Enums\ProcessingStatus;
use App\Domain\Cnab\Exceptions\InvalidStateException;
use App\Domain\Cnab\Models\CNABProcessing;

class PendenteState
{
    public function start(CNABProcessing $processing): void
    {
        $processing->status = ProcessingStatus::PROCESSANDO;
        $processing->save();
    }

    public function complete(CnabProcessing $processing, string $cnabFilePath): void
    {
        throw new InvalidStateException('Não é possível completar um processamento que ainda está pendente.');
    }

    public function fail(CnabProcessing $processing, string $errorMessage): void
    {
        throw new InvalidStateException('Não é possível falhar um processamento que ainda está pendente.');
    }
}
