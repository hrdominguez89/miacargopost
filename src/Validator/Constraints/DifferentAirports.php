<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class DifferentAirports extends Constraint
{
    public $message = 'El aeropuerto de origen no puede ser el mismo que el aeropuerto de destino.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
