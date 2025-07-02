<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pilot extends Model
{
    /** @use HasFactory<\Database\Factories\PilotFactory> */
    use HasFactory;

    public function company(): BelongsTo{
        return $this->belongsTo(Company::class);
    }

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class);
    }

    public function renewableTrainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class)
            ->where('expiresNever',false)
            ->withPivot('date');
    }
}
