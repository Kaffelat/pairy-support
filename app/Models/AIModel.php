<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AIModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'openai_id',
        'type',
        'epochs',
        'max_tokens',
        'temparture',
    ];

    public function modelData(): HasOne
    {
        return $this->hasOne(ModelData::class, 'model_data_id');
    }

    public function modelTraningHistory(): HasMany
    {
        return $this->hasMany(ModelTraningHistory::class, 'model_validation_id');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
