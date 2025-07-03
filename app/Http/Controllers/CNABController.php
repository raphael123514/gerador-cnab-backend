<?php

namespace App\Http\Controllers;

use App\Domain\Cnab\Jobs\ProcessCnabFile;
use App\Domain\Cnab\Models\CNABProcessing;
use App\Domain\Cnab\Requests\CNABImportRequest;

class CNABController extends Controller
{
     /**
     * Lista todos os processamentos com filtros e paginação.
     * Acessível por Admin e Usuário. 
     */
    public function index(Request $request)
    {
        // Valida os parâmetros de filtro da requisição
        $validated = $request->validate([
            'status' => 'sometimes|in:pendente,processando,concluido,erro',
            'date_from' => 'sometimes|date_format:Y-m-d',
            'date_to' => 'sometimes|date_format:Y-m-d',
        ]);

        $query = CnabProcessing::query()
            // Carrega o nome do usuário solicitante para evitar N+1 queries [cite: 24]
            ->with('user:id,name');

        // Aplica os filtros se eles existirem na requisição 
        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $query->when($request->filled('date_from'), function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->date_from);
        });

        $query->when($request->filled('date_to'), function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->date_to);
        });
        
        // Ordena pelos mais recentes e pagina o resultado
        $processings = $query->latest()->paginate(15);

        return response()->json($processings);
    }

    /**
     * Recebe o arquivo Excel e dispara o job de processamento.
     * Acessível apenas por Admin. 
     */
    public function import(CNABImportRequest $request)
    {
        // dd($request->validated());

        $path = $request->file('file_upload')->store('imports');
        
        $processing = auth()->user()->cnabProcessings()->create([
            'fund_id' => $request->input('fund_id'),
            'file_sequence' => $request->input('file_sequence'),
            'original_filename' => $request->file('file_upload')->getClientOriginalName(),
            'original_filepath' => $path,
            'status' => 'pendente',
        ]);
        
        ProcessCnabFile::dispatch($processing);
        
        return response()->json([
            'message' => 'Arquivo recebido. Em breve o processamento será iniciado.',
            'data' => $processing
        ], 202);
    }

    /**
     * Permite o download do arquivo original ou do CNAB gerado. [cite: 25]
     */
    public function download(CNABProcessing $processing, $type)
    {
        // Opcional: Adicionar mais uma verificação de permissão aqui
        // Gate::authorize('view-processing', $processing);

        $path = null;
        if ($type === 'excel' && $processing->original_filepath) {
            $path = $processing->original_filepath;
        } elseif ($type === 'cnab' && $processing->cnab_filepath) {
            $path = $processing->cnab_filepath;
        }

        if (!$path || !Storage::exists($path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::download($path);
    }
}
