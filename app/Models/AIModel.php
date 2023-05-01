<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class AIModel extends Model
{
    use HasFactory;

    protected $table = 'ai_models';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'user_id',
        'ai_file_id',
        'openai_id',
        'type',
        'epochs',
        'max_tokens',
        'temparture',
    ];

    protected $typeList = [
        'davinci',
        'curie'
    ];


    /**
    * Relation to Model Data
    */
    public function modelData(): HasMany
    {
        return $this->hasMany(ModelData::class, 'model_data_id');
    }
    
    /**
    * Relation to Model Validation
    */
    public function modelValidation(): HasMany
    {
        return $this->hasMany(ModelValidation::class, 'model_validation_id');
    }
    
    /**
    * Relation to Users
    */
    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
