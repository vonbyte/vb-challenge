<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePilotRequest;
use App\Http\Requests\UpdatePilotRequest;
use App\Models\Company;
use App\Models\Pilot;

class PilotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pilots = Pilot::all();
            return [
                'data' => $pilots,
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
    public function store(StorePilotRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pilot $pilot)
    {
        $pilot->load('trainings');
        try {
            return [
                'data' => $pilot,
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
    public function update(UpdatePilotRequest $request, Pilot $pilot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pilot $pilot)
    {
        //
    }
}
