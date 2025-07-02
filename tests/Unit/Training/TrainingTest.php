<?php

use App\Models\Pilot;
use App\Models\Training;

it('has the expected attributes', function () {
    $fields = ['name','expirationPeriod','expiresEndOfMonth','expiresNever', 'renevalPeriod'];
    $company = \App\Models\Training::factory()->make();

    expect(array_keys($company->getAttributes()))->toBe($fields);
});

it('writes the model to the database', function () {
    $company = Training::factory()->create();

    $this->assertDatabaseHas($company->getTable(), $company->getAttributes());
});

it('belongs to zero or many pilots', function () {
    $training = \App\Models\Training::factory()
        ->hasAttached(
            Pilot::factory()->count(3),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->create();

    expect($training->pilots->count())->toBe(3);
    expect($training->pilots->first())->toBeInstanceOf(Pilot::class);
});

it('has the correct status if is permanent', function () {
    $training = Training::factory()->create([
        'expiresNever' => true,
    ]);

    expect($training->getStatus(true))->toBe('permanent');
});


//    $this->assertEquals(TrainingStatus::VALID_PERMANENT, $training->getStatus());
//    $this->assertNull($training->calculateExpiryDate());
//    $this->assertFalse($training->canBeRenewed());
//    $this->assertNull($training->getDaysUntilExpiry());


