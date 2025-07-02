<?php

use App\Models\Training;

it('has a pilot index route', function () {
    $url = route('api.pilot.index');
    $response = $this->get($url);

    $response->assertStatus(200);
});

it('lists all pilots', function () {
    App\Models\Pilot::factory()->count(5)->create();
    $url = route('api.pilot.index');
    $response = $this->get($url);
    $pilots = $response->json()['data'];
    expect($pilots)->toHaveCount(5);
});

it('retreives a single pilot', function () {
    $pilotModel = \App\Models\Pilot::factory()->create();
    $url = route('api.pilot.show', $pilotModel->id);

    $response = $this->get($url);

    $pilot = $response->json()['data'];

    expect($pilot)->toHaveKeys(array_keys($pilotModel->getAttributes()));
    expect($pilot['name'])->toEqual($pilotModel->name);
});

it('retreives a single pilot with trainings', function () {
    $pilotModel = \App\Models\Pilot::factory()
        ->hasAttached(
            Training::factory()->count(3),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->create();
    $url = route('api.pilot.show', $pilotModel->id);

    $response = $this->get($url);

    $pilot = $response->json()['data'];

    expect($pilot['trainings'])->toHaveCount(3);
});



