<?php

use Illuminate\Support\Facades\Request;
use App\Helpers\SiteHelpers;

function getIcon($icon)
{
	return file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/icons/' . $icon);
}

function getCommonIcon($name)
{
	return file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/icons/common/' . $name . '.svg');
}

function getStorageIcon($name)
{
	return file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/storage/' . $name);
}

function getStorageFile($name)
{
	return '/storage/' . $name;
}

function getBlockName(string $name): string
{
	return 'b-' . $name;
}

function getExt($filename)
{
	return substr(strrchr($filename, '.'), 1);
}

function getLink($link)
{
	return $link;
}

function getRouteLink($link)
{
	return '/' . getRouteName() . '/' . $link;
}

function getRouteName()
{
	if (Request::route() !== null) return Request::route()->getName();
}

function getPhoneField($phone)
{
	return SiteHelpers::getPhoneHref($phone);
}

function isMain()
{
	return Request::route() ? Request::route()->getName() === 'home' : false;
}

function pickFirstWord($string, $class = false)
{
	$words = explode(' ', $string);
	$len = count($words);
	$result = '<span' . ($class ? ' class="' . $class . '"' : '') . '>' . $words[0] . '</span>';
	for ($i = 1; $i < $len; ++$i) {
		$result .= ' ' . $words[$i];
	}
	return $result;
}
