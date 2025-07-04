<?php

namespace App\Domain\Fund\Actions;

use App\Domain\Fund\Models\Fund;

class GetAllFundAction
{
    /**
     * Retorna todos os fundos disponíveis.
     */
    public function execute(): array
    {
        return Fund::all()->toArray();
    }
}
