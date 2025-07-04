<?php

namespace App\Domain\Cnab\States;

use App\Domain\Cnab\Exceptions\InvalidStateException;
use App\Domain\Cnab\Models\CNABProcessing;

class ConcluidoState
{
    public function start(CNABProcessing $processing): void
    {
        throw new InvalidStateException('Este processamento já foi concluído.');
    }
}
