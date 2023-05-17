<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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
        'batch_size',
        'learning_rate_multiplier',
        'prompt_loss_weight'
    ];

    protected $typeList = [
        'davinci',
        'curie'
    ];
    
    /**
    * Relation to Users
    */
    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function fineTuneJob(): BelongsTo
    {
        return $this->belongsTo(FineTuneJob::class);
    }
}
