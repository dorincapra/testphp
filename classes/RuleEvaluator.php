<?php

	class RuleEvaluator extends RuleOperation
	{
		private $data;

		public function __construct($data)
		{
			$this->data = $data;
		}

		public function evaluate($context, $stop = 0)
		{
			if( $context instanceof RuleContext )
			{
				$context = $context->getContext();

				if(count($context['operands']) == 0)
				{
					return true;
				}
			}

			$data = $this->data;
			$result = false;
			$operator = $context['operator'];

			if( isset($context['operands'][0]) )
			{
				$operands = array();

				foreach($context['operands'] as $key => $item)
				{
					$operands[] = $this->evaluate($item);
				}

				if(count($operands))
				{
					foreach( $operands as $key => $operand )
					{
						if( !isset($tmp) )
						{
							$tmp = $operand;
							continue;
						}

						$operation = $this->getOperation($operator);
						$tmp = $this->$operation($tmp, $operand);
					}

					$result = $tmp;
				}
				else
				{
					$result = false;
				}
			}
			else
			{
				$keys = array_keys($context['operands']);
				$key = array_pop($keys);

				if(!isset($data[$key]))
				{
					$data[$key] = '';
				}

				if(isset($data[$key]))
				{
					$operation = $this->getOperation($operator);
					$result = $this->$operation($data[$key], $context['operands'][$key]);
				}
			}

			return $result;
		}
	}
