<?php

namespace App\Validator\Constraints;

use App\Entity\Flights;
use App\Repository\FlightsRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueFlightValidator extends ConstraintValidator
{
    private $flightsRepository;

    public function __construct(FlightsRepository $flightsRepository)
    {
        $this->flightsRepository = $flightsRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueFlight) {
            throw new UnexpectedTypeException($constraint, UniqueFlight::class);
        }

        if (!$value instanceof Flights) {
            throw new UnexpectedValueException($value, Flights::class);
        }

        // Buscar si ya existe un vuelo con los mismos valores
        $existingFlight = $this->flightsRepository->findOneBy([
            'originAirport' => $value->getOriginAirport(),
            'arrivalAirport' => $value->getArrivalAirport(),
            'flightNumber' => $value->getFlightNumber(),
            'flightFrequency' => $value->getFlightFrequency(),
            'departureTime' => $value->getDepartureTime(),
            'arrivalTime' => $value->getArrivalTime(),
            'aircraftType' => $value->getAircraftType(),
            'discontinueDate' => $value->getDiscontinueDate(),
            'effectiveDate' => $value->getEffectiveDate(),
        ]);

        if ($existingFlight !== null && $existingFlight->getId() !== $value->getId()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
