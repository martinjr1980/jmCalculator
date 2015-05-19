<?php

class Calculator
{
	public function evaluate($equation)
	{
		$pattern = "/([-+*%\/])/";
		$originalEq = preg_split($pattern, $equation, -1, PREG_SPLIT_DELIM_CAPTURE);
		$modifiedEq = array();
		$origLen = count($originalEq);

		for ($i = 0; $i < $origLen; $i++)
		{
			$operator = $originalEq[$i];

			if ($operator === '+' || $operator === '-')
			{
				array_push($modifiedEq, floatval($originalEq[$i - 1]), $operator);
			}
			elseif ($operator === '*' || $operator === '/' || $operator === '%')
			{
				$initial = floatval($originalEq[$i - 1]);
				$result = $this->recursiveMultDiv($originalEq, $i, $initial);
				$i = $result[1];

				array_push($modifiedEq, $result[0]);

				if ($i !== $origLen - 1)
				{
					array_push($modifiedEq, $originalEq[$i]);
				}
			}
		}

		$modLen = count($modifiedEq);

		for ($j = 0; $j < $modLen; $j++)
		{
			$operator = $modifiedEq[$j];

			if ($operator === '+' || $operator === '-')
			{
				$initial = floatval($modifiedEq[$j - 1]);
				$result = $this->recursiveAddSub($modifiedEq, $j, $initial);
				$total = $result[0];
				break;
			}
		}

		return $total;
	}	

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
		elseif ($i === count($array) - 1)
		{
			return array($result, $i);
		}

		return $this->recursiveAddSub($array, $i + 1, $result);
	}

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
		elseif ($array[$i] === '+' || $array[$i] === '-' || $i === count($array) - 1)
		{
			return array($result, $i);
		}

		return $this->recursiveMultDiv($array, $i + 1, $result);
	}
}

$calculator = new Calculator();
echo $calculator->evaluate('1+2*3-4%5+6/7-8*9%10');

?>