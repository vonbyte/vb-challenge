<?php

it('has a company index route', function () {
    $url = route('api.company.index');
    $response = $this->get($url);

    $response->assertStatus(200);
});

it('lists all companies', function () {
    $company = \App\Models\Company::factory()->count(5)->create();
    $url = route('api.company.index');
    $response = $this->get($url);
    $companies = $response->json()['data'];
    expect($companies)->toHaveCount(5);
});

it('retreives a single company', function () {
    $companyModel = \App\Models\Company::factory()->create();
    $url = route('api.company.show', $companyModel->id);

    $response = $this->get($url);

    $company = $response->json()['data'];

    expect($company)->toHaveKeys(array_keys($companyModel->getAttributes()));
    expect($company['name'])->toEqual($companyModel->name);
});

it('retreives a single company with pilots', function () {
    $companyModel = \App\Models\Company::factory()
        ->has(\App\Models\Pilot::factory()->count(3))
        ->create();

    $url = route('api.company.show', $companyModel->id);

    $response = $this->get($url);

    $company = $response->json()['data'];

    expect($company['pilots'])->toHaveCount(3);
});
