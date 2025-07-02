<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class PilotController extends Controller
{
    /**
     * Display a listing of pilots.
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
     * Display the specified pilot.
     */
    public function show(Pilot $pilot)
    {
        try {
            $pilot->load('trainings');

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
     * Display trainings by the specified pilot.
     */
    public function showTrainings(Pilot $pilot)
    {
        try {
            $pilot->load('trainings');

            return [
                'data' => $pilot->trainings,
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
     * Get critical trainings for a specific pilot
     */
    public function showCriticalTrainings(Pilot $pilot)
    {
        try {
            $trainings = $this->getCriticalTrainings($pilot);

            return [
                'data' => $trainings,
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
     * Get Expired trainings for a specific user
     */
    public function showExpiredTrainings(Pilot $pilot)
    {

        try {
            $trainings = $this->getExpiredTrainings($pilot);

            return [
                'data' => $trainings,
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
     * @param Pilot $pilot
     * @return Collection
     */
    protected function getCriticalTrainings(Pilot $pilot): Collection
    {
        // ToDo: we want to put this on the model basis later to avoid crowded controllers
        $trainings = $pilot->renewableTrainings;
        $trainings->filter(function ($training) {
            $expiryDate = Carbon::parse($training->pivot->date)->addMonths($training->expirationPeriod);
            $renevalDate = Carbon::parse($training->pivot->date)->addMonths($training->expirationPeriod)->subMonths($training->renevalPeriod);
            // ToDo we have to set the says on the model as mutators, so that we can deliver the effective days via API
            //$expiryDays = $today->diffInDays($expiryDate, false);
            //$renevalDays = $expiryDate->diffInDays($renevalDate, false);

            return Carbon::today()->between($renevalDate, $expiryDate);
        });
        return $trainings;
    }

    /**
     * @param Pilot $pilot
     * @return Collection
     */
    protected function getExpiredTrainings(Pilot $pilot): Collection
    {
        // ToDo: we want to put this on the model basis later to avoid crowded controllers
        $trainings = $pilot->renewableTrainings;
        $trainings->filter(function ($training) {
            $expiryDate = Carbon::parse($training->pivot->date)->addMonths($training->expirationPeriod);
            $today = Carbon::today();
            // ToDo we have to set the says on the model as mutators, so that we can deliver the effective days via API
            //$expiryDays = $today->diffInDays($expiryDate, false);
            return $expiryDate->diffInDays($today) <= 0;
        });
        return $trainings;
    }
}
