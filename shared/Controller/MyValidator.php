<?php
class Controller_MyValidator extends Controller_Validator_Advanced {

	function rule_alphaspace($a)
    {
        $msg = 'must contain only letters';
        if(!preg_match('/^([A-Za-z ])*$/', $a)) return $this->fail($msg);
    }
}
