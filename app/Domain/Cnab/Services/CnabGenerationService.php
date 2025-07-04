<?php

namespace App\Domain\Cnab\Services;

use App\Domain\Cnab\Support\CnabFormatter;
use App\Domain\Fund\Models\Fund;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CnabGenerationService
{
    private string $header;

    private array $bodyLines = [];

    private string $footer;

    private float $totalValue = 0.0;

    private const CODEBANK = '341';

    private const AGENCY = '12345';

    private const ACCOUNT = '987651';

    /**
     * Método principal que orquestra a geração do CNAB.
     */
    public function generate(Fund $fund, string $sequence, Collection $excelRows): string
    {
        $this->buildHeader($fund, $sequence);
        $this->buildBody($excelRows);
        $this->buildFooter();

        return $this->header."\n".implode("\n", $this->bodyLines)."\n".$this->footer;
    }

    private function buildHeader(Fund $fund, string $sequence): void
    {
        $name = CnabFormatter::alpha($fund->name, 10);
        $cnpj = str_replace(['.', '-', '/'], '', $fund->cnpj);
        $street = CnabFormatter::alpha($fund->address_street, 10);
        $number = CnabFormatter::numeric($fund->address_number, 3);
        $sequence = CnabFormatter::numeric($sequence, 3);

        $this->header = $name.$cnpj.$street.$number.$sequence;
    }

    private function buildBody(Collection $excelRows): void
    {
        foreach ($excelRows as $index => $row) {
            $valorOriginal = (float) $row['valor'];

            if ($valorOriginal > 9999.99) {
                $linhaNoExcel = $index + 2;
                throw new \Exception("Valor '{$valorOriginal}' na linha {$linhaNoExcel} do Excel excede o limite permitido.");
            }

            $contract = CnabFormatter::numeric($row['contrato'], 6);
            $customer = CnabFormatter::alpha($row['cliente'], 22);
            $value = CnabFormatter::money($valorOriginal, 6);
            $date = Date::excelToDateTimeObject($row['data'])->format('Ymd');

            $this->bodyLines[] = $contract.$customer.$value.$date;
            $this->totalValue += $valorOriginal;
        }
    }

    private function buildFooter(): void
    {
        $sum = CnabFormatter::money($this->totalValue, 10);
        $bank = CnabFormatter::numeric(self::CODEBANK, 3);
        $agency = CnabFormatter::numeric(self::AGENCY, 5);
        $account = CnabFormatter::numeric(self::ACCOUNT, 6);

        $this->footer = $sum.$bank.$agency.$account;
    }
}
