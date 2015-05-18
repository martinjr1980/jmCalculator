<?php

class Calculator {
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
echo $calculator->modulus(1, 2);


?>