<?php

namespace App\Domain\Cnab\Jobs;

use App\Domain\Cnab\Models\CnabProcessing;
use App\Domain\Cnab\Services\CnabGenerationService;
use App\Domain\Fund\Models\Fund;
use App\Imports\CnabImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use Throwable;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProcessCnabFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public CnabProcessing $processing)
    {
    }

    public function handle(Excel $excel, CnabGenerationService $cnabService): void
    {
        $this->processing->startProcessing();
        $this->processing->refresh();
        
        try {
            $import = new CnabImport();
            $excel->import($import, $this->processing->original_filepath);
            $excelRows = $import->data;
            
            $fund = Fund::find($this->processing->fund_id);
            if (!$fund) {
                throw new \Exception("Fundo com ID {$this->processing->fund_id} não encontrado.");
            }
            
            $fileContent = $cnabService->generate(
                $fund,
                $this->processing->file_sequence,
                $excelRows
            );

            $filename = 'cnab_'. $this->processing->id . '_' . now()->format('YmdHis') . '.txt';
            $cnabFilePath = 'cnab_generated/' . $filename;
            Storage::put($cnabFilePath, $fileContent);

            $this->processing->markAsCompleted($cnabFilePath);

        } catch (Throwable $e) {
            $this->processing->markAsFailed($e->getMessage());
            \Log::error("Erro ao processar CNAB", [
                'processing_id' => $this->processing->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
