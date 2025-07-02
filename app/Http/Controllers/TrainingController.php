<?php

namespace App\Http\Controllers;

use App\Models\Training;

class TrainingController extends Controller
{
    /**
     * Display a listing of trainings.
     */
    public function index()
    {
        try {
            $pilots = Training::all();
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
     * Display the specified training.
     */
    public function show(Training $training)
    {
        try {
            $training->load('pilots');
            return [
                'data' => $training,
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

}
