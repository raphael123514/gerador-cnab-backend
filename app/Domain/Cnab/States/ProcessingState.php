<?php

namespace App\Domain\Cnab\States;

use App\Domain\Cnab\Models\CNABProcessing;

interface ProcessingState
{
    public function start(CNABProcessing $processing): void;

    public function complete(CnabProcessing $processing, string $cnabFilePath): void;

    public function fail(CnabProcessing $processing, string $errorMessage): void;
}
