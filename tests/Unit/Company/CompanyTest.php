<?php

use App\Models\Company;
use App\Models\Pilot;

it('has the expected attributes', function () {
    $fields = ['name'];
    $company = Company::factory()->make();

    expect(array_keys($company->getAttributes()))->toBe($fields);
});

it('writes the model to the database', function () {
    $company = Company::factory()->create();

    $this->assertDatabaseHas($company->getTable(), $company->getAttributes());
});

it('has one or more pilots', function () {
    $company = Company::factory()
        ->has(\App\Models\Pilot::factory()->count(3))
        ->create();

    expect($company->pilots->count())->toBe(3);
    expect($company->pilots->first())->toBeInstanceOf(Pilot::class);
});

