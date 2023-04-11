<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ModelData extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'tokens',
        'validering',
        'traning'
    ];

    public function aiModel(): BelongsToMany
    {
        return $this->belongsToMany(AIModel::class, 'ai_model_id');
    }

    public function modelTraningHistory(): BelongsTo
    {
        return $this->belongsTo(ModelTraningHistory::class);
    }
}
