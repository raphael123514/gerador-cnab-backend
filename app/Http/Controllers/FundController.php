<?php

namespace App\Http\Controllers;

use App\Domain\Fund\Actions\GetAllFundAction;
use App\Domain\Fund\Resources\FundResource;

class FundController extends Controller
{
    public function index(GetAllFundAction $getAllFundAction)
    {
        $data = $getAllFundAction->execute();
        
        return FundResource::collection($data);
    }
}
