<?php

use App\Models\Pilot;
use App\Models\Training;

it('has a training index route', function () {
    $url = route('api.training.index');
    $response = $this->get($url);

    $response->assertStatus(200);
});

it('lists all trainings', function () {
    App\Models\Training::factory()->count(5)->create();
    $url = route('api.training.index');
    $response = $this->get($url);
    $trainings = $response->json()['data'];
    expect($trainings)->toHaveCount(5);
});

it('retreives a single training', function () {
    $trainingModel = \App\Models\Training::factory()->create();
    $url = route('api.training.show', $trainingModel->id);

    $response = $this->get($url);

    $training = $response->json()['data'];

    expect($training)->toHaveKeys(array_keys($trainingModel->getAttributes()));
    expect($training['name'])->toEqual($trainingModel->name);
});

it('retreives a single training with pilots', function () {
    $trainingModel = \App\Models\Training::factory()
        ->hasAttached(
            Pilot::factory()->count(3),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->create();
    $url = route('api.training.show', $trainingModel->id);

    $response = $this->get($url);

    $training = $response->json()['data'];

    expect($training['pilots'])->toHaveCount(3);
});

it('retreives a all trainings from a single pilot', function () {
    $pilot1Model = \App\Models\Pilot::factory()
        ->hasAttached(
            Training::factory()->count(4),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->create();
    $pilot2Model = \App\Models\Pilot::factory()
        ->hasAttached(
            Training::factory()->count(2),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(2)]
        )
        ->create();

    $url = route('api.pilot.training.show', $pilot1Model->id);
    $response = $this->get($url);
    $trainings = $response->json()['data'];
    expect($trainings)->toHaveCount(4);

    $url = route('api.pilot.training.show', $pilot2Model->id);
    $response = $this->get($url);
    $trainings = $response->json()['data'];
    expect($trainings)->toHaveCount(2);


});

it('retreives a all critical trainings from a single pilot', function () {
    $trainingModel = \App\Models\Pilot::factory()
        ->hasAttached(
            Training::factory()->count(3),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->create();
    $url = route('api.training.show', $trainingModel->id);

    $response = $this->get($url);

    $training = $response->json()['data'];

    expect($training['trainings'])->toHaveCount(3);
});

it('retreives a all expired trainings from a single pilot', function () {
    $trainingModel = \App\Models\Pilot::factory()
        ->hasAttached(
            Training::factory()->count(3),
            ['date' => \Illuminate\Support\Carbon::now()->subDays(5)]
        )
        ->create();
    $url = route('api.training.show', $trainingModel->id);

    $response = $this->get($url);

    $training = $response->json()['data'];

    expect($training['trainings'])->toHaveCount(3);
});
