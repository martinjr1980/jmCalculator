<?php

class Calculator
{
	public function evaluate($string)
	{
		$pattern = "/([-+*%\/])/";
		$array = preg_split($pattern, $string, -1, PREG_SPLIT_DELIM_CAPTURE);
		$len = count($array);
		$total = 0;
		var_dump($array);
		for ($i = 0; $i < $len; $i++)
		{
			if ($array[$i] === '*' || $array[$i] === '/' || $array[$i] === '%')
			{
				$a = floatval($array[$i-1]);
				$b = floatval($array[$i+1]);
				$total = $this->operators($array[$i], $a, $b);
				$array[$i-1] = 0;
				$array[$i] = '+';
				$array[$i+1] = $total;
				var_dump($array);
			}
		}

		for ($j = 0; $j < $len; $j++)
		{
			if ($array[$j] === '+' || $array[$j] === '-')
			{
				$a = floatval($array[$j-1]);
				$b = floatval($array[$j+1]);
				$total = $this->operators($array[$j], $a, $b);
				$array[$j-1] = 0;
				$array[$j] = '+';
				$array[$j+1] = $total;
				var_dump($array);
			}
		}
		echo $total;
	}	

	function operators($string, $a, $b)
	{
		if ($string === '+')
		{
			return $a + $b;
		}
		elseif ($string === '-')
		{
			return $a - $b;
		}
		elseif ($string === '*')
		{
			return $a * $b;
		}
		elseif ($string === '/')
		{
			return $a / $b;
		}
		elseif ($string === '%')
		{
			return $a % $b;
		}
	}
}

$calculator = new Calculator();
$calculator->evaluate('1+2*3-4%5+6/7-8*9%10');
// $eval = 1+2*3-4%5+6/7-8*9%10;
// echo $eval;
?>