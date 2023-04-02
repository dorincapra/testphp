<?php

	class RuleOperation
	{
		private static $data  = [];

		private $operators = array(
			'AND' => '__and',
			'OR' => '__or',
			'EQUALS' => '__equals',
			'EQUALORGREATER' => '__equalOrGreater',
			'LESSEROREQUAL' => '__lesserOrEqual',
			'GREATER' => '__greater',
			'LESSER' => '__lesser',
			'NOTEQUAL' => '__notEqual',
			'IN' => '__in',
			'NOTIN' => '__notIn'
		);

		protected function __and($operand1, $operand2)
		{
			return $operand1 && $operand2;
		}

		protected function __or($operand1, $operand2)
		{
			return $operand1 || $operand2;
		}

		protected function __equals($operand1, $operand2)
		{
			$return = false;

			if(is_array($operand1))
			{
				$operand2 = explode(',', trim($operand2, ','));

				if(count($operand2) == count($operand1))
				{
					$tempArray = array_intersect($operand1, $operand2);

					if(count($tempArray) == count($operand2))
					{
						$return = true;
					}
					else
					{
						$return  = false;
					}
				}
				else
				{
					$return = false;
				}
			}
			else
			{
				$return = $operand1 == $operand2 ? true : false;
			}

			return $return;
		}

		protected function __equalOrGreater($operand1, $operand2)
		{
			$return = false;

			if(is_array($operand1))
			{
				$operand2 = explode(',', trim($operand2,','));
				$tempArray = array_intersect($operand2, $operand1);

				if(count($tempArray) == count($operand2))
				{
					$return = true;
				}
				else
				{
					$return  = false;
				}
			}
			else
			{
				$return = $operand1 >= $operand2 ? true : false;
			}

			return $return;
		}

		protected function __lesserOrEqual($operand1, $operand2)
		{
			$return = false;

			if(is_array($operand1))
			{
				$operand2 = explode(',', trim($operand2, ''));
				$tempArray = array_intersect($operand1, $operand2);

				if(count($tempArray) == count($operand1))
				{
					$return = true;
				}
				else
				{
					$return  = false;
				}
			}
			else
			{
				$return = $operand1 <= $operand2 ? true : false;
			}

			return $return;
		}

		protected function __greater($operand1, $operand2)
		{
			$return = false;

			if(is_array($operand1))
			{
				$operand2 = explode(',', trim($operand2, ','));
				$tempArray = array_intersect($operand2, $operand1);

				if(count($tempArray) == count($operand2))
				{
					$return = true;
				}
				else
				{
					$return  = false;
				}
			}
			else
			{
				$return = $operand1 > $operand2 ? true : false;
			}

			return $return;
		}

		protected function __lesser($operand1, $operand2)
		{
			$return = false;

			if(is_array($operand1))
			{
				$operand2 = explode(',', trim($operand2, ','));
				$tempArray = array_intersect($operand1, $operand2);

				if(count($tempArray) == count($operand1))
				{
					$return = true;
				}
				else
				{
					$return  = false;
				}
			}
			else
			{
				$return = $operand1 < $operand2 ? true : false;
			}

			return $return;
		}

		protected function __notEqual($operand1, $operand2)
		{
			$return = false;

			if(is_array($operand1))
			{
				$operand2 = explode(',', trim($operand2, ','));
				$tempArray = array_intersect($operand1, $operand2);

				if(count($tempArray))
				{
					$return = false;
				}
				else
				{
					$return  = true;
				}
			}
			else
			{
				$return = $operand1 != $operand2 ? true : false;
			}

			return $return;
		}

		protected function __in($operand1, $operand2)
		{
			$return = false;

			if(!isset(self::$data[md5($operand2)]))
			{
				self::$data[md5($operand2)] = array_flip(array_map('trim', explode(',', trim($operand2, ','))));
			}

			$operand2 = self::$data[md5($operand2)];

			if(is_array($operand1))
			{
				foreach($operand1 as $value)
				{
					if(isset($operand2[$value]))
					{
						$return = true;

						break;
					}
				}

			}
			else
			{
				$operand1 = is_array($operand1) ? $operand1 : explode(',', trim($operand1, ','));

				foreach($operand1 as $value)
				{
					if(isset($operand2[$value]))
					{
						$return = true;

						break;
					}
				}

			}

			return $return;
		}

		protected function __notIn($operand1, $operand2)
		{
			$return = true;

			if(!isset(self::$data[md5($operand2)]))
			{
				self::$data[md5($operand2)] = array_flip(array_map('trim', explode(',', trim($operand2, ','))));
			}

			$operand2 = self::$data[md5($operand2)];

			if(is_array($operand1))
			{
				foreach($operand1 as $value)
				{
					if(isset($operand2[$value]))
					{
						$return = false;
						break;
					}
				}
			}
			else
			{
				$operand1 = array_filter(explode(',', trim($operand1, ',')));

				foreach($operand1 as $value)
				{
					if(isset($operand2[$value]))
					{
						$return = false;
						break;
					}
				}

			}

			return $return;
		}

		public function isValidOperation($operator)
		{
			return isset($this->operators[$operator]);
		}

		public function getOperation($operator)
		{
			return $this->operators[$operator];
		}
	}
