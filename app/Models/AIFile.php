<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class AIFile extends Model
{
    use HasFactory;

    protected $table = 'ai_files';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'openai_id',
        'user_id',
        'name',
        'byte_size',
        'file_purpose'
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
