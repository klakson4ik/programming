<?php

$finder = (new PhpCsFixer\Finder())
	->in('src')
;

return (new PhpCsFixer\Config())
	->setRules([
		'@Symfony' => true,
		'declare_strict_types' => true,
		'php_unit_method_casing' => [
			'case' => 'snake_case'
		]
	])
	->setFinder($finder);