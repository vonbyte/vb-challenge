<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Training extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingFactory> */
    use HasFactory;

    protected $casts = [
        'expiresEndOfMonth' => 'boolean',
        'expiresNever' => 'boolean',
        'expirationPeriod' => 'integer',
        'renevalPeriod' => 'integer',
    ];

    // ToDo see Controller, we will add the values here via model mutators
    protected $appends = [

        //'expirationDate',
        //'status',
        //'daysUntilExpiration',
        //'daysUntilReneval',
        //'canBeRenewed',
    ];

    public function pilots(): BelongsToMany
    {
        return $this->belongsToMany(Pilot::class);
    }


}
