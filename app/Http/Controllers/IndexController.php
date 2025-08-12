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
use Illuminate\Support\Facades\DB; 

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

	// public function actioncontent()
	// {
	// 	$contents = TContent::all();
	// 	return view('home/content', ['contents' => $contents]);
	// }
	public function actionContent()
	{
		$categoryIcons = [
			'Canciones' => '<i class="fas fa-music" style="color: #e91e63; font-size: 2rem;"></i>',
			'Cuentos y Relatos' => '<i class="fas fa-book-open" style="color: #ff9800; font-size: 2rem;"></i>',
			'Artículos Educativos' => '<i class="fas fa-graduation-cap" style="color: #2196f3; font-size: 2rem;"></i>',
			'Guías y Manuales' => '<i class="fas fa-clipboard-list" style="color: #4caf50; font-size: 2rem;"></i>',
			'Infografías y Carteles' => '<i class="fas fa-palette" style="color: #9c27b0; font-size: 2rem;"></i>',
			'Juegos y Actividades' => '<i class="fas fa-gamepad" style="color: #f44336; font-size: 2rem;"></i>',
			'Experimentos Caseros' => '<i class="fas fa-flask" style="color: #ffeb3b; font-size: 2rem;"></i>',
			'Noticias' => '<i class="fas fa-newspaper" style="color: #607d8b; font-size: 2rem;"></i>',
			'Importancia del Agua' => '<i class="fas fa-tint" style="color: #00bcd4; font-size: 2rem;"></i>',
			'El Agua para Consumo Humano' => '<i class="fas fa-glass-whiskey" style="color: #03a9f4; font-size: 2rem;"></i>',
			'Otros Usos del Agua' => '<i class="fas fa-water" style="color: #009688; font-size: 2rem;"></i>',
			'Garantizando la Calidad del Agua' => '<i class="fas fa-shield-alt" style="color: #8bc34a; font-size: 2rem;"></i>',
			'Tensiones en Torno al Agua' => '<i class="fas fa-balance-scale" style="color: #ff5722; font-size: 2rem;"></i>',
			'El Uso Responsable del Agua' => '<i class="fas fa-recycle" style="color: #4caf50; font-size: 2rem;"></i>',
			'Fascículos 1' => '<i class="fas fa-file-alt" style="color: #795548; font-size: 2rem;"></i>',
			'Fascículos 2' => '<i class="fas fa-file-pdf" style="color: #9e9e9e; font-size: 2rem;"></i>',
			'Fascículos 3' => '<i class="fas fa-scroll" style="color: #607d8b; font-size: 2rem;"></i>',
			'Fascículos 4' => '<i class="fas fa-file-contract" style="color: #795548; font-size: 2rem;"></i>',
			'Fascículos 5' => '<i class="fas fa-bookmark" style="color: #9e9e9e; font-size: 2rem;"></i>',
			'Fascículos 6' => '<i class="fas fa-file-invoice" style="color: #607d8b; font-size: 2rem;"></i>'
		];
		$contents = DB::table('tcontent')
			->where('status', 1)
			->whereNotNull('published_at')
			->where('published_at', '<=', now())
			->whereNotNull('category')
			->where('category', '!=', '')
			->orderBy('is_featured', 'desc')
			->orderBy('sort_order', 'asc')
			->get()
			->groupBy('category');

		$videos = DB::table('tvideo')
			->where('status', 1)
			->whereNotNull('category')
			->where('category', '!=', '')
			->orderBy('sort_order', 'asc')
			->get()
			->groupBy('category');

		$categoriesWithContent = [];
		foreach ($contents as $category => $categoryContents) {
			$categoriesWithContent[$category] = [
				'icon' => $categoryIcons[$category] ?? '<i class="fas fa-folder" style="color: #9e9e9e; font-size: 2rem;"></i>',
				'contents' => $categoryContents,
				'videos' => $videos[$category] ?? collect()
			];
		}
		foreach ($videos as $category => $categoryVideos) {
			if (!isset($categoriesWithContent[$category])) {
				$categoriesWithContent[$category] = [
					'icon' => $categoryIcons[$category] ?? '<i class="fas fa-folder" style="color: #9e9e9e; font-size: 2rem;"></i>',
					'contents' => collect(),
					'videos' => $categoryVideos
				];
			}
		}

		return view('home.content', compact('categoriesWithContent'));
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
