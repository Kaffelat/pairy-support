<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FineTuneJob extends Model
{
    use HasFactory;

    protected $table = 'fine_tune_jobs';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'ai_model_id',
        'ai_file_id',
        'ai_model_result_file_id',
        'openai_id',
        'type',
        'events',
        'epochs',
        'batch_size',
        'learning_rate_multiplier',
        'prompt_loss_weight'
    ];

    public function aiModelResultFile(): HasOne
    {
        return $this->hasOne(AIModelResultFile::class, 'ai_model_result_file_id');
    }

    public function aiModel(): BelongsTo
    {
        return $this->belongsTo(AIModel::class, 'ai_model_id');
    }

    public function aiFile(): HasMany
    {
        return $this->hasMany(AIFile::class);
    }
}
