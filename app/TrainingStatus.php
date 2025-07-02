<?php

namespace App;

enum TrainingStatus: string
{

    // ToDo: We should use the states as abstracted enums (not implemented yet)
    case VALID_PERMANENT = 'valid_permanent';
    case VALID = 'valid';
    case CRITICAL = 'critical';
    case EXPIRED = 'expired';
}
