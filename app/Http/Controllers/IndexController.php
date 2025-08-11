<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TVideo;
use App\Models\TContent;
use App\Models\TGallery;
use App\Models\TUser;
use App\Models\TProvince;
use Illuminate\Support\Carbon;
use App\Models\ModalSetting;
use Illuminate\Support\Facades\Cache;
use App\Models\TImage;

class IndexController extends Controller
{
	public function actionIndex()
	{

		$modal = Cache::remember('active_modal', 60, function () {
			return ModalSetting::where('is_active', true)
				->where('start_date', '<=', now())
				->where('end_date', '>=', now())
				->first();
		});

		// Retorna la vista con los datos del modal
		return view('home.index', compact('modal'));
	}

	public function actionGallery()
	{
		$imagesByInstitution = TImage::with([
			'tWater.tInstitution.tDistrict.tProvince',
			'tWater.tInstitution.tUgel'
		])
			->whereNotNull('urlImage1')
			->orderBy('created_at', 'desc')
			->get()
			->groupBy('tWater.tInstitution.name');

		$videos = TVideo::all();

		return view('home/gallery', [
			'imagesByInstitution' => $imagesByInstitution,
			'videos' => $videos
		]);
	}

	public function actioncontent()
	{
		$contents = TContent::all();
		return view('home/content', ['contents' => $contents]);
	}

	public function actioncontentDetail($id)
	{
		$content = TContent::where('id', $id)->first();
		$video = TVideo::where('id', $id)->first();
		return view('home/content_detail', ['content' => $content, 'video' => $video]);
	}

	public function actionInstitution()
	{
		$provinces = TProvince::with(['tDistrict.tInstitution'])->get();

		$totalInstitutions = $provinces->sum(function ($province) {
			return $province->tDistrict->sum(function ($district) {
				return $district->tInstitution->count();
			});
		});

		return view('home.institution', compact('provinces', 'totalInstitutions'));
	}

	public function actionIndexAdmin()
	{
		return view('index/indexadmin');
	}
}
