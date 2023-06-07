<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    * Relation to User
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    /**
    * Relation to fineTuneJob
    */
    public function fineTuneJob(): HasMany
    {
        return $this->hasMany(FineTuneJob::class,'ai_file_id');
    }

}
