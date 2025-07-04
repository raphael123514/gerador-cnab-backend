<?php

namespace App\Http\Controllers;

use App\Domain\Cnab\Actions\CreateCnabProcessingAction;
use App\Domain\Cnab\Actions\ListCnabProcessingsAction;
use App\Domain\Cnab\Jobs\ProcessCnabFile;
use App\Domain\Cnab\Models\CNABProcessing;
use App\Domain\Cnab\Requests\CNABImportRequest;
use App\Domain\Cnab\Requests\CNABProcessingListRequest;
use App\Domain\Cnab\Resources\CNABProcessingResource;
use Illuminate\Support\Facades\Storage;

class CNABController extends Controller
{
    /**
     * Lista todos os processamentos com filtros e paginação.
     * Acessível por Admin e Usuário.
     */
    public function index(CNABProcessingListRequest $request, ListCnabProcessingsAction $listCnabProcessingsAction)
    {
        $processings = $listCnabProcessingsAction->execute($request->validated());

        return CNABProcessingResource::collection($processings);
    }

    /**
     * Recebe o arquivo Excel e dispara o job de processamento.
     * Acessível apenas por Admin.
     */
    public function upload(CNABImportRequest $request, CreateCnabProcessingAction $createCnabProcessingAction)
    {
        $validatedData = $request->validated();

        $path = $validatedData['file_upload']->store('imports');

        $processing = $createCnabProcessingAction->execute(
            auth()->user(),
            $validatedData,
            $path
        );

        ProcessCnabFile::dispatch($processing);

        return response()->json([
            'message' => 'Arquivo recebido. Em breve o processamento será iniciado.',
            'data' => new CNABProcessingResource($processing),
        ], 202);
    }

    /**
     * Permite o download do arquivo original ou do CNAB gerado.
     */
    public function download(CNABProcessing $processing, $type)
    {

        $path = null;
        if ($type === 'excel' && $processing->original_filepath) {
            $path = $processing->original_filepath;
        } elseif ($type === 'cnab' && $processing->cnab_filepath) {
            $path = $processing->cnab_filepath;
        }

        if (! $path || ! Storage::exists($path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::download($path);
    }
}
