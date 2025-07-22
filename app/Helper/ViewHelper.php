<?php
namespace App\Helper;

use Illuminate\Support\Facades\Session;

class ViewHelper
{
	public static function renderPagination($urlPage, $quantityPage, $currentPage, $searchParameter)
	{
		$searchParameter=($searchParameter!='' && $searchParameter!=null) ? '?searchParameter='.$searchParameter : '';

		$paginationSection=''
			.'<div class="divPagination">'
				.'<span><a class="divPaginationJump" onclick="_globalFunction.clickLink(\''.url($urlPage.'/'.(($currentPage-1)<=0 ? 1 : ($currentPage-1))).$searchParameter.'\');"></a></span>'
				.'<a onclick="_globalFunction.clickLink(\''.url($urlPage.'/1').$searchParameter.'\');" class="divPaginationPageNumber" '.(1==$currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : '').'>1</a>';
		if($currentPage-2>1)
		{
			$paginationSection.='..';
		}
		
		for($i=($currentPage-2<=1 ? 2 : $currentPage-2); $i<=($quantityPage<($currentPage+2) ? $quantityPage : $currentPage+2); $i++)
		{
			$paginationSection.='<a onclick="_globalFunction.clickLink(\''.url($urlPage.'/'.$i).$searchParameter.'\');" class="divPaginationPageNumber" '.($i==$currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : '').'>'.$i.'</a>';
		}
		if($quantityPage>($currentPage+2))
		{
			$paginationSection.='..'
				.'<a onclick="_globalFunction.clickLink(\''.url($urlPage.'/'.$quantityPage).$searchParameter.'\');" class="divPaginationPageNumber" '.($quantityPage==$currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : '').'>'.$quantityPage.'</a>';
		}
		
		$paginationSection.='<span><a class="divPaginationJump" onclick="_globalFunction.clickLink(\''.url($urlPage.'/'.(($currentPage+1)>$quantityPage ? $quantityPage : ($currentPage+1))).$searchParameter.'\');"></a></span>'
			.'</div>';

		return $paginationSection;
	}

	public static function hasMainRole($role)
	{
		return Session::has('mainRole') ? in_array($role, explode(',', Session::get('mainRole'))) : false;
	}

	public static function hasSecondaryRole($role, $columnSession, $columnValue)
	{
		if(Session::has('arrayCompanyRole'))
		{
			foreach(Session::get('arrayCompanyRole') as $value)
			{
				if(($columnSession==null && $columnValue==null && in_array($role, explode(',', $value->role))) || ($value->$columnSession==$columnValue && in_array($role, explode(',', $value->role))))
				{
					return true;
				}
			}
		}

		return false;
	}

	public static function addToDate($dateHour, $type, $quantity)
	{
		/*+7 year, +7 month, +7 day, +7 hour, +7 minute, +7 second*/
		$newDateHour=strtotime( '+'.$quantity.' '.$type , strtotime($dateHour));
		$newDateHour=date('Y-m-d H:i:s' , $newDateHour);

		return $newDateHour;
	}

	public static function dateToCache($date)
	{
		return str_replace(':', '-', str_replace(' ', '_', $date));
	}

	public static function getDateFormat($date, $formatOut='d-m-Y')
	{
		return date($formatOut, strtotime($date));
	}

	public static function findValueOnObjectsArray($array, $column, $valueFind)
	{
		foreach($array as $value)
		{
			if($value->{$column}==$valueFind)
			{
				return true;
			}
		}

		return false;
	}
}
?>