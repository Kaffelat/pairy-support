<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ModelValidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'traning_loss',
        'traning_sequence_accuracy',
        'traning_token_accuracy',
        'elapsed_tokens',
        'elapsed_eksemples'
    ];

    public function modelData(): HasOne
    {
        return $this->hasOne(ModelData::class, 'model_data_id');
    }

    public function aiModel(): BelongsTo
    {
        return $this->belongsTo(AIModel::class, 'ai_model_id');
    }
}
