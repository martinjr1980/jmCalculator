<?php

class Calculator {
	public function evaluate($string) {
		$pattern = "/([-+*%\/])/";
		$array = preg_split($pattern, $string, -1, PREG_SPLIT_DELIM_CAPTURE);
		$len = count($array);
		$total = 0;
		for ($i = 0; $i < $len; $i++) {
			if ($array[$i] === '+') {
				$a = (int) $array[$i-1];
				$b = (int) $array[$i+1];
				array_shift($array);
				array_shift($array);
				$total = $this->add($a, $b);
				$array[0] = $total;
				$i = 0;
				$len -= 2;
			} elseif ($array[$i] === '-') {
				$a = (int) $array[$i-1];
				$b = (int) $array[$i+1];
				array_shift($array);
				array_shift($array);
				$total = $this->subtract($a, $b);
				$array[0] = $total;
				$i = 0;
				$len -= 2;
			}
		}
		echo $total;
	}

	function add($a, $b) {
		return $a + $b;
	}

	function subtract($a, $b) {
		return $a - $b;
	}

	function multiply($a, $b) {
		return $a * $b;
	}

	function divide($a, $b) {
		return $a / $b;
	}

	function modulus($a, $b) {
		return $a % $b;
	}
}

$calculator = new Calculator();

$calculator->evaluate('3 + 5 + 1 + 9 - 18 + 4');


?>