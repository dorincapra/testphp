<?php

	require_once('classes/RuleOperation.php');
	require_once('classes/RuleEvaluator.php');
	require_once('classes/RuleContext.php');
	require_once('classes/RuleProposition.php');
	require_once('classes/RulePropositionGroup.php');
	require_once('classes/Rule.php');

	$rule = new Rule();
	$rule->buildRuleContext();

	/**
	 * PRODUCT DATA MUST REMAIN UNCHANGED
	 */
	$matches = $rule->applyDiscounts([
		[
			'product:sku' => 'sku1',
			'product:price' => 50
		],
		[
			'product:sku' => 'sku2',
			'product:price' => 120
		],
		[
			'product:sku' => 'sku3',
			'product:price' => 110
		]
	]);

	if(!count($matches))
	{
		print 'No rule applied';
	}
	else
	{
		foreach($matches as $match)
		{
			print $match['applied_discount'].' was applied for product '.$match['product:sku'].'<br>';
		}
	}
