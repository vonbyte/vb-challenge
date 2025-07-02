<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
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
     * Display the specified company.
     */
    public function show(Company $company)
    {
        try {
            $company->load('pilots');
            return [
                'data' => $company,
                'success' => true,
                'error' => null,
            ];
        } catch (\Throwable $th) {
            // ToDo: Handle proper error state with headers
            return [
                'data' => [],
                'success' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

}
