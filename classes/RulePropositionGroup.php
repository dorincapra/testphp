<?php

	class RulePropositionGroup extends RuleOperation
	{
		private $operator;
		private $propositions;

		public function __construct()
		{
			$args = func_get_args();

			if(count($args) == 2)
			{
				$operator = $args[0];

				if(!$this->isValidOperation($operator))
				{
					throw new Exception('RulePropositionGroup Class: Invalid operator');
				}

				array_shift($args);

				foreach($args as $item)
				{
					if( !($item instanceof RuleProposition) && !($item instanceof RulePropositionGroup))
					{
						throw new Exception('RuleProposition Class: Invalid proposition in group');
					}
				}

				$this->operator = $operator;
				$this->propositions = $args;
			}
		}

		//add operator
		public function addOperator($operator)
		{
			if(!$this->isValidOperation($operator))
			{
				throw new Exception('RulePropositionGroup Class: Invalid operator');
			}

			$this->operator = $operator;

		}

		//add proposition
		public function addProposition($proposition)
		{
			if( !($proposition instanceof RuleProposition) && !($proposition instanceof RulePropositionGroup))
			{
				throw new Exception('RuleProposition Class: Invalid proposition in group');
			}

			$this->propositions[] = $proposition;
		}

		public function toArray()
		{
			return array(
				'operator' => $this->operator,
				'operands' => $this->propositions
			);
		}
	}
