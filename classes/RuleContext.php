<?php

	class RuleContext
	{
		private $context;

		public function __construct($context)
		{
			$this->context = $context;
		}

		public function __getContext($context)
		{

			if($context instanceof RulePropositionGroup)
			{
				$propositions = $context->toArray();

				$result = array(
					'operator' => $propositions['operator'],
					'operands' => array()
				);

				if(isset($propositions['operands']))
				{
					foreach($propositions['operands'] as $item)
					{
						$result['operands'][] = $this->__getContext($item);
					}
				}
			}
			elseif($context instanceof RuleProposition)
			{
				$result = $context->toArray();
			}
			else
			{
				die('RuleContext Class: Invalid rule type');
			}

			return $result;
		}

		public function getContext()
		{
			return $this->__getContext($this->context);
		}
	}
