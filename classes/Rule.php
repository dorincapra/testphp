<?php

	class Rule
	{
		private static $__rules;

		/**
		 * DATA RETURNED BY THIS METHOD MUST REMAIN UNCHANGED
		 */
		private  function initRules()
		{
			self::$__rules = [
				[
					'name' => '10% Discount',
					'conditions' => [
						1 => [
							'aggregator' => 'IS',
							'operator' => 'OR',
							'operands' => [
								[
									'operand' => 'product:sku',
									'operator' => 'IN',
									'value' => 'SKU1,SKU3',
								],
								[
									'operand' => 'product:price',
									'operator' => 'GREATER',
									'value' => '100',
								],
							],
						],
					]
				]
			];
		}

		public function getRules()
		{
			if(NULL === self::$__rules)
			{
				$this->initRules();
			}

			return self::$__rules;
		}

		public function buildRuleContext()
		{
			if(!self::$__rules)
			{
				$rules = $this->getRules();

				$callback = function(array $data) use (&$callback)
				{
					if(!isset($data['operator']))
					{
						$group = new RulePropositionGroup();

						if(is_array($data))
						{
							foreach($data as $value)
							{
								$group = new RulePropositionGroup();
								$group->addOperator($value['operator']);
								foreach($value['operands'] as $operand)
								{
									$group->addProposition( $callback($operand) );
								}
							}
						}

						return $group;

					}
					elseif(isset($data['operand']))
					{
						return new RuleProposition($data['operand'], $data['operator'], $data['value']);
					}
				};

				foreach($rules as $key => $rule)
				{
					$rules[$key]['context'] = new RuleContext($callback($rule['conditions']));
				}

				self::$__rules = $rules;

			}

			return self::$__rules;
		}

		public function applyDiscounts($products)
		{
			$matches = [];

			foreach(self::$__rules as $rule)
			{
				foreach($products as $product)
				{
					$ev = new RuleEvaluator($product);

					if($ev->evaluate($rule['context']))
					{
						$match = $product;
						$match['applied_discount'] = $rule['name'];
						$matches[] = $match;
					}
				}
			}

			return $matches;
		}
	}
