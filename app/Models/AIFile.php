<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function delete()
    {
        #Update the associated FineTuneJob records
        $this->fineTuneJob()->update(['ai_file_id' => null]);

        return parent::delete();
    }

    /**
    * Relation to Model Validation
    */
    public function fineTuneJob(): BelongsToMany
    {
        return $this->belongsToMany(FineTuneJob::class,'ai_file_fine_tune_job_pivot', 'ai_file_id', 'fine_tune_job_id');
    }

}
