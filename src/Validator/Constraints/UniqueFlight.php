<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueFlight extends Constraint
{
    public $message = 'Ya existe un vuelo con las mismas caracteristicas.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
