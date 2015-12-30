<?php

namespace Tkuska\ValidationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RegonValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint) {
        
        if ($value == '') {
            $this->context->buildViolation($constraint->message)
            ->setParameter('%string%', $value)
            ->addViolation();
        }
        
        $value = preg_replace("/[^0-9]+/", "", $value);


        if(strlen($value) == 9){
            $weights = array(8, 9, 2, 3, 4, 5, 6, 7);
        }elseif(strlen($value) == 14){
            $weights = array(2, 4, 8, 5, 0, 9, 7, 3, 6, 1, 2, 4, 8);
        }else{
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
        
        $sum = 0;
        for($i = 0;$i < count($weights); $i++){
        	$sum += $weights[$i] * $value[$i];
        }
        $int = $sum % 11;
        $checksum = ($int == 10) ? 0 : $int;
        if($checksum == $value[count($weights)]){
            return true;	
        }
        
        $this->context->buildViolation($constraint->message)
        ->setParameter('%string%', $value)
        ->addViolation();

    }

}
