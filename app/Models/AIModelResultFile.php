<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AIModelResultFile extends Model
{
    use HasFactory;

    protected $table = 'ai_model_result_files';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'ai_model_id',
        'ai_file_id',
        'openai_id',
        'byte_size',
        'file_purpose'
    ];

    public function fineTuneJob(): BelongsTo
    {
        return $this->belongsTo(fineTuneJob::class, 'id');
    }
}
