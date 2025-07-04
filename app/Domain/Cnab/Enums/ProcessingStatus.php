<?php

namespace App\Domain\Cnab\Enums;

enum ProcessingStatus: string
{
    case PENDENTE = 'pendente';
    case PROCESSANDO = 'processando';
    case CONCLUIDO = 'concluido';
    case ERRO = 'erro';
}
