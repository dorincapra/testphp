<?php

	class RuleProposition extends RuleOperation
	{
		private $operator;
		private $leftOperand;
		private $rightOperand;

		public function __construct($leftOperand, $operator, $rightOperand)
		{
			$operator = $operator == '' ? 'IN' : $operator;

			if(!$this->isValidOperation($operator))
			{
				throw new ApplicationException('RuleProposition Class: Invalid operator');
			}

			$this->leftOperand = $leftOperand;
			$this->rightOperand = $rightOperand;
			$this->operator = $operator;
		}

		public function toArray()
		{
			return array(
				'operator' => $this->operator,
				'operands' => array($this->leftOperand => $this->rightOperand)
			);
		}
	}
