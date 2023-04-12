<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ModelValidation extends Model
{
    use HasFactory;

    protected $table = 'model_validation';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'traning_loss',
        'traning_sequence_accuracy',
        'traning_token_accuracy',
        'elapsed_tokens',
        'elapsed_examples'
    ];

    /**
    * Relation to Model Data
    */
    public function modelData(): HasOne
    {
        return $this->hasOne(ModelData::class, 'model_data_id');
    }

    /**
    * Relation to AI Model
    */
    public function aiModel(): BelongsTo
    {
        return $this->belongsTo(AIModel::class, 'ai_model_id');
    }
}
