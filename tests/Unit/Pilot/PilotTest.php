<?php

use App\Models\Pilot;
use App\Models\Training;

it('has the expected attributes', function () {
    $fields = ['name','lastname','birthdate','mail', 'company_id'];
    $pilot = \App\Models\Pilot::factory()->make();

    expect(array_keys($pilot->getAttributes()))->toBe($fields);
});

it('writes the model to the database', function () {
    $pilot = \App\Models\Pilot::factory()->create();

    $this->assertDatabaseHas($pilot->getTable(), $pilot->getAttributes());
});

it('belongs to a company', function () {
    $pilot = \App\Models\Pilot::factory()
        ->for(\App\Models\Company::factory()->state([
            'name' => 'Test company',
        ]))
        ->create();

    expect($pilot->company)->toBeInstanceOf(\App\Models\Company::class);
    expect($pilot->company->name)->toBe('Test company');
});

it('belongs to zero or many trainings', function () {
    $pilot = \App\Models\Pilot::factory()
        ->hasAttached(
            Training::factory()->count(3),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->create();

    expect($pilot->trainings->count())->toBe(3);
    expect($pilot->trainings->first())->toBeInstanceOf(Training::class);
});

it('retrieves renevable trainings', function () {
    $pilot = \App\Models\Pilot::factory()
        ->hasAttached(
            Training::factory()
                ->state(function (array $attributes) {
                    return ['expiresNever' => true];
                })
                ->count(1),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->hasAttached(
            Training::factory()
                ->state(function (array $attributes) {
                    return ['expiresNever' => false];
                })
                ->count(3),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->create();

    expect($pilot->renewableTrainings->count())->toBe(3);
});
