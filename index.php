<?php

class Calculator
{
	// Main method used to evaluate the equation
	public function evaluate($equation)
	{
		// The accepted operators are +, -, *, /, and %
		$pattern = "/([-+*%\/])/";

		// Converts string into array separated by operators
		$originalEq = preg_split($pattern, $equation, -1, PREG_SPLIT_DELIM_CAPTURE);
		$modifiedEq = array();
		$origLen = count($originalEq);

		// Loop through array that represents original equation
		for ($i = 0; $i < $origLen; $i++)
		{
			$operator = $originalEq[$i];

			// Check for multiply/divide/modulus operator and evaluate first
			if ($operator === '*' || $operator === '/' || $operator === '%')
			{
				$initial = floatval($originalEq[$i - 1]);

				// Recursive method to evaulate successive mult/div/mod operations
				$result = $this->recursiveMultDiv($originalEq, $i, $initial);

				// Redefine $i so you don't repeat items in the array
				$i = $result[1];

				// Add result to the modified equations array
				array_push($modifiedEq, $result[0]);

				// Unless you've reached end of the array, add next operator to modified eq array
				// Otherwise the next + or - will be lost
				if ($i !== $origLen - 1)
				{
					array_push($modifiedEq, $originalEq[$i]);
				}
			}
			// If you find an add/subtract operator, add it to the modified equations array
			// These will be evaluated at the end
			elseif ($operator === '+' || $operator === '-')
			{
				// Also need to add the number before the add/subtract operator
				array_push($modifiedEq, floatval($originalEq[$i - 1]), $operator);
			}
		}

		// Now the modified equations array should only contain numbers with add/subtract operators

		$modLen = count($modifiedEq);
		$initial = floatval($modifiedEq[0]);

		// Recursive method to evaluate all the add/subtract operators until you reach the end
		$total = $this->recursiveAddSub($modifiedEq, 0, $initial);

		return $total;
	}	

	// Method for multiply, divide, and modulus
	private function recursiveMultDiv($array, $i, $result)
	{
		if ($array[$i] === '*')
		{
			$result *= floatval($array[$i + 1]);
		} 
		elseif ($array[$i] === '/')
		{
			$result /= floatval($array[$i + 1]);
		}
		elseif ($array[$i] === '%')
		{
			$result %= $array[$i + 1];
		}
		// If you find an add/subtract operator or reach the end of the array...
		// Return the result and the current index value
		elseif ($array[$i] === '+' || $array[$i] === '-' || $i === count($array) - 1)
		{
			return array($result, $i);
		}

		// Evaluate next item in the array
		return $this->recursiveMultDiv($array, $i + 1, $result);
	}

	// Method for add and subtract
	private function recursiveAddSub($array, $i, $result)
	{
		if ($array[$i] === '+')
		{
			$result = $result + floatval($array[$i + 1]);
		}
		elseif ($array[$i] === '-')
		{
			$result = $result - floatval($array[$i + 1]);
		}
		// If you reach the end of the array, return the result
		elseif ($i === count($array) - 1)
		{
			return $result;
		}

		// Evaluate next item in the array
		return $this->recursiveAddSub($array, $i + 1, $result);
	}
}

// $before = microtime(true);
$calculator = new Calculator();
echo $calculator->evaluate('1+2*3-4%5+6/7-8*9%10+0*123');
// $after = microtime(true);
// var_dump ($after-$before);

?>