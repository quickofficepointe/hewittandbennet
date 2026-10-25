<?php

namespace App\Http\Controllers\Portal\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Unit;

abstract class TrainerController extends Controller
{
    /** Trainers may only manage the units assigned to them. */
    protected function authorizeUnit(Unit $unit): void
    {
        abort_unless($unit->trainer_id === auth()->id(), 403, 'This unit is not assigned to you.');
    }
}
