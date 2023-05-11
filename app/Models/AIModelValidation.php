<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AIModelValidation extends Model
{
    use HasFactory;

    protected $table = 'ai_model_validation';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'ai_model_id',
        'ai_file_id',
        'openai_id'
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
