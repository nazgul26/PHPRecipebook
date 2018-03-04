<?php
App::uses('AppHelper', 'View/Helper');
/**
	These methods are used for converting a decimal such as .333 to a fraction (1/3)
*/
class FractionHelper extends AppHelper {
	var $whole;
	var $fraction;
	/* *
		Function that drives the conversion of a decimal to a fraction
		@param $value decimal to convert
		@param $period the character that represents a comma (could be ',' in some countries)
	*/
	public function toFraction($value) {
            $this->whole = 0;
            $this->fraction = 0;
            
            if (strstr($value, "."))
            {
                // Now convert the decimal part to a fraction
                list($integer_part,$decimal_part) = explode(".", $value, 2);
                $decimal_part = "." . $decimal_part;
                $loop=0;
                $result=array();
                $this->decimalToFraction($decimal_part,$loop,$result);
                if ($integer_part == '0') $integer_part="";
                // Simplify the fraction
                $this->simplifyFraction($result);
                $this->whole = $integer_part;
            } else {
                // It is a whole number.
                $this->whole = $value;
            }
            if ($this->fraction != "") {
                $returnValue = $this->whole != "" ? $this->whole . " " : "";
                $returnValue .= $this->fraction;
                return ($returnValue);
            }
            else return ($this->whole);
	}
	
	/**
		Converts a decimal to a fraction
		@param $decimal Decimal to convert
		@param $loop counter to keep track of state
		@param $result pointer to the resulting fraction
	*/
	private function decimalToFraction($decimal,$loop,&$result) {
            $a = (1.0/(float)$decimal);
            $b = ( $a - floor($a) );
            $loop++;
            if ($b > .01 && $loop <= 5) $this->decimalToFraction($b,$loop,$result);
            $result[$loop] = floor($a);
	}

	/**
		Simplifies a fraction
		@param $fraction fraction to convert
		@param $loop keeps track of state
		@param $top the top of the fraction
		@param $bottom the bottom of the fraction
	*/
	private function simplifyFraction($fraction) {
            $loop = count($fraction);
            $top = 1;
            $bottom = $fraction[$loop];
            while ($loop > 0) {
                $next = 0;
                if (isset($fraction[$loop - 1]))
                        $next = $fraction[$loop-1];
                $a = ($bottom * $next) + $top;
                $top = $bottom;
                $bottom = $a;
                $loop--;
            }
            $this->fraction = "$bottom/$top";
	}
	
	/**
		Converts a string that represents a fraction to a double, this function can be
		called statically.
		@param $str The string to convert
		@return A floating point number
	*/
	private function strToFloat($str) {
            $ret = 0;
            if (is_numeric($str))
            {
                return ($str);
            }
            else
            {
                $pieces = explode(" ", $str);
                if (count($pieces) == 2)
                {
                    $whole = $pieces[0];
                    $frac = $pieces[1];
                    if (preg_match("/\//", $pieces[0], $matches)) {
                            $frac = $whole;
                            $ret = 0;
                    } else $ret = $whole;
                }
                else
                {
                    $frac = $str; // only a fraction	
                }

                // Now deal with the fraction part
                if ($frac) {
                    list($top,$bot) = explode('\/', $frac);
                    if ($top > 0 && $bot > 0) 
                            $ret += ($top / $bot);
                }
                return $ret;
            }
	}
}
?>