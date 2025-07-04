<?php

namespace App\Domain\Cnab\Models;

use App\Domain\Cnab\Enums\ProcessingStatus;
use App\Domain\Cnab\States\ConcluidoState;
use App\Domain\Cnab\States\ErroState;
use App\Domain\Cnab\States\PendenteState;
use App\Domain\Cnab\States\ProcessandoState;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CNABProcessing extends Model
{
    protected $table = 'cnab_processings';

    protected $fillable = [
        'user_id',
        'fund_id',
        'file_sequence',
        'original_filename',
        'original_filepath',
        'cnab_filepath',
        'status',
    ];

    protected $casts = [
        'status' => ProcessingStatus::class,
    ];

    protected function state(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status) {
                ProcessingStatus::PENDENTE => new PendenteState(),
                ProcessingStatus::PROCESSANDO => new ProcessandoState(),
                ProcessingStatus::CONCLUIDO => new ConcluidoState(),
                ProcessingStatus::ERRO => new ErroState(),
            }
        );
    }

    public function startProcessing(): void
    {
        $this->state->start($this);
    }
    
    public function markAsCompleted(string $cnabFilePath): void
    {
        $this->state->complete($this, $cnabFilePath);
    }
    
    public function markAsFailed(string $errorMessage = ''): void
    {
        $this->state->fail($this, $errorMessage);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
