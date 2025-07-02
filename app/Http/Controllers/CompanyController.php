<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $companies = Company::all();
            return [
                'data' => $companies,
                'success' => true,
                'error' => null,
            ];
        } catch (\Throwable $th) {
            return [
                'data' => [],
                'success' => false,
                'error' => $th->getMessage(),
            ];
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load('pilots');
        try {
            return [
                'data' => $company,
                'success' => true,
                'error' => null,
            ];
        } catch (\Throwable $th) {
            return [
                'data' => [],
                'success' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
