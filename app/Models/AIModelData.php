<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AIModelData extends Model
{
    use HasFactory;

    protected $table = 'ai_model_data';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'data',
        'tokens',
        'validering',
        'traning'
    ];

    /**
    * Relation to AI Model
    */
    public function aiModel(): BelongsToMany
    {
        return $this->belongsToMany(AIModel::class, 'ai_model_id');
    }

    /**
    * Relation to Model Validation
    */
    public function modelValidation(): BelongsToMany
    {
        return $this->belongsToMany(ModelValidation::class);
    }
}
