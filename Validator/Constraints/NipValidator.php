<?php

namespace Tkuska\ValidationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NipValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value == '') {
            return true;
        }
        $value = preg_replace("/[^0-9]+/", "", $value);
        if (strlen($value) != 10) {
            $this->context->buildViolation($constraint->message)
                    ->setParameter('%string%', $value)
                    ->addViolation();

        }
        $arrSteps = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
        $intSum = 0;
        for ($i = 0; $i < 9; $i++) {
            $intSum += $arrSteps[$i] * $value[$i];
        } $int = $intSum % 11;
        $intControlNr = ($int == 10) ? 0 : $int;
        if ($intControlNr == $value[9]) {
            return true;
        }
        $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
    }

}
