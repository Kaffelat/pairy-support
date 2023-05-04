<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AIFile extends Model
{
    use HasFactory;

    protected $table = 'ai_file';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'openai_id',
        'user_id',
        'name',
        'data',
        'byte_size',

        'tokens',
        'validering',
        'traning',
        'file_purpose'
    ];

    protected $casts = [
        'traning' => 'bool',
        'validering' => 'bool',
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
