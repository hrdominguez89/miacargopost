<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Entity\Flights; // Asegúrate de usar tu entidad adecuada

class DifferentAirportsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof DifferentAirports) {
            throw new UnexpectedTypeException($constraint, DifferentAirports::class);
        }

        if (!$value instanceof Flights) {
            throw new UnexpectedValueException($value, Flights::class);
        }

        // Comprueba si los aeropuertos de origen y destino son iguales
        if ($value->getOriginAirport() === $value->getArrivalAirport()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('arrivalAirport') // Puedes poner 'originAirport' si prefieres
                ->addViolation();
        }
    }
}
