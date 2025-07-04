<?php

namespace App\Domain\Cnab\Support;

class CnabFormatter
{
    /**
     * Formata um campo alfanumérico (texto).
     * Trunca o texto no tamanho correto e preenche com espaços à direita.
     */
    public static function alpha(string $value, int $length): string
    {
        return str_pad(mb_substr($value, 0, $length), $length, ' ', STR_PAD_RIGHT);
    }

    /**
     * Formata um campo numérico (números).
     * Trunca o número no tamanho correto e preenche com zeros à esquerda.
     */
    public static function numeric(string|int $value, int $length): string
    {
        return str_pad(mb_substr($value, 0, $length), $length, '0', STR_PAD_LEFT);
    }

    /**
     * Formata um valor monetário.
     * Converte para centavos e preenche com zeros à esquerda.
     */
    public static function money(float $value, int $length): string
    {
        $inCents = (int) round($value * 100);

        return self::numeric($inCents, $length);
    }
}
