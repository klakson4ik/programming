<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Video;
use App\Models\Publications;
use App\Models\ProductPublication;

use App\Helpers\ImageHelpers;
use App\Models\Page\ProductPage;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{

	protected $data;

	public function __construct()
	{
		$this->data = ProductPage::get();
	}
	/**
	 * Отображает страницу продукта по URL и идентификатору предложения.
	 *
	 * @param string $url URL продукта.
	 * @param int|null $code Идентификатор предложения (если есть).
	 */
	public function index($url, $code = null)
	{
		// Получаем товар с его предложениями по URL
		$product = Product::GetItems()->with('offers')->get()->firstWhere('url', $url);

		// Если продукт не найден, возвращаем 404
		if (!$product) throw new NotFoundHttpException();

		// Конкретный товар, не торговое предложение
		$this->data['product'] = $product;

		$offers = $product->offers->where('active', true)->sortBy('sort')->toArray();

		$product->file = collect($product->file)->where('active', true)->sortBy('sort')->toArray();


		$product['images'] = ImageHelpers::getImage('/storage/' . $product['images']);
		ImageHelpers::resizeImagesFromArrayByKey($offers, false, 'images');

		$this->data['main']['offers'] = $offers; // Добавляем предложения

		foreach ($this->data['main']['offers'] as $idx => &$element) {
			$element['parentElement'] = $product['url'];
			$element['count'] = $idx++;
			if ($element['images'] === null) $element['images'] = $product->toArray()['images'];
		};

		$this->data['main']['slider'] = [
			'cards' => 	$this->data['main']['offers'],
			'cardTemplate' => 'pages.detail-product.part.detail-card',
		];

		$allProducts = Product::GetItems()->get()->toArray();

		foreach ($allProducts as $oneProduct) {
			if (isset($oneProduct['videos']) && is_array($oneProduct['videos'])) {
				foreach ($oneProduct['videos'] as $video) {
					// Проверяем, что title не null и хотя бы одно из video или video_vk не null
					if ($video['title'] !== null && ($video['video'] !== null || $video['video_vk'] !== null)) {
						$videos[] = [
							'title' => $video['title'],
							'video' => $video['video'],
							'preview' => $video['preview'],
							'video_vk' => $video['video_vk'],
						];
					}
				}
			}
		}

		// Получение слайдера для экрана "Техника введения"
		$technologies = $product['technologies'];
		$filteredTechnologies = [];
		$index = 0;

		foreach ($technologies as $item) {
			if (!$item['image']) break;
			if (!$item['active']) continue;
			$index++;
			$item['image'] = ImageHelpers::getImage('/storage/' . $item['image']);
			$item['number'] = $index;
			$filteredTechnologies[] = $item;
		}

		$technologies = $filteredTechnologies;

		$this->data['techniques']['slider'] = [
			'cards' => $technologies,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.detail-product.part.technologies-card'
		];
		$this->data['techniques']['name'] = $product['name'];


		if (count($this->data['techniques']['slider']['cards']) < 1) {
			$this->data['pagination'] = array_filter($this->data['pagination'], function ($el) {
				return $el['anchor'] !== "b-techniques";
			});

			$this->data['pagination'] = array_values($this->data['pagination']);
		}

		$publications = Publications::getItemsArray();
		ImageHelpers::getImagesArray($publications, 'image');

		// Работа с видео
		$videos = Video::get()->toArray();
		foreach ($videos as $key => $video) {
			if ($video['video_vk'] == null && $video['video'] == null)
				unset($videos[$key]);
		}

		$videos = array_values($videos);
		$videoIds = [];

		// Видео для данного продукта
		$productWithVideo = Product::with('videos')->where('active', 1)->get()->toArray();
		$videosThisProduct = [];
		$this->data['videoInstructions']['videoId'] = '';
		foreach ($productWithVideo as $el) {
			foreach ($el['videos'] as $elem) {
				if ($elem['pivot']['product_id'] === $product['id']) {
					array_push($videosThisProduct, $elem);
					$videoIds[] = $elem['pivot']['video_id'];
				}
			}
		}

		$remainingVideos = Video::select('id', 'name', 'videos')
			->whereNotIn('id', $videoIds)
			->has('products')
			->distinct()
			->count();
		if ($remainingVideos === 0)
			$this->data['videoInstructions']['uniqueVideosFlag'] = false;

		$this->data['videoInstructions']['videoId'] = implode(',', $videoIds);
		$this->data['videoInstructions']['html'] = $this->renderVideoHtml($videosThisProduct);

		$publications_id = $product['id'] ?? '';
		$productPublication = ProductPublication::all()->toArray();

		$activeProductPublication = [];
		foreach ($productPublication as $el) {
			if ($el['product_id'] == $publications_id)
				array_push($activeProductPublication, $el['publication_id']);
		}

		foreach ($activeProductPublication as $id) {
			foreach ($publications as $item) {
				if ($item['id'] == $id) {
					$sortedPublications[] = $item;
					break;
				}
			}
		}

		foreach ($publications as $item) {
			if (!in_array($item['id'], $activeProductPublication)) {
				$sortedPublications[] = $item;
			}
		}


		$this->data['publications']['slider'] = [
			'cards' => $sortedPublications,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.detail-product.part.publications-card',
		];

		$productCards = Product::getItemsArray();
		ImageHelpers::resizeImagesFromArrayByKey($productCards, [false, false, '540'], 'images');

		foreach ($productCards as $key => $el) {
			if ($el['url'] === $url) {
				unset($productCards[$key]);
			}
		}

		$this->data['otherProduct']['slider'] = [
			'cards' => $productCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.home.part.product-card'
		];

		// Если передан code, получаем конкретное предложение
		if ($code) {
			$offer = $product->offers()->where('url', $code)->first();

			// Добавляем конкретное предложение. Если такого торгового предложения нет, то 404
			$offer ? $this->data['offer'] = $offer : throw new NotFoundHttpException('Offers not found');

			if (!empty($offer['images'])) $offer['images'] = ImageHelpers::getImage('/storage/' . $offer['images']);

			$this->prepareMeta($product, $offer);
		} else {
			// Если перешли по ссылке, где в url нет торгового предложения,
			// то показывается приоритетное торг.предлож. в товаре
			$offer = $product->offers()->where('id', $product['priority_offer_id'])->first();

			return redirect()->route('product', ['url' => $url, 'code' =>  $offer['url']]);
		}

		$this->data['breadcrumbsAdd'] = [
			[
				'name' => $this->data['product']['name'],
				'url' => '/product/' . $this->data['product']['url'],
			],
			[
				'name' => $this->data['offer']['name'],
				'url' => '/product/' . $this->data['product']['url'] . '/' . $this->data['offer']['url'],
			],
		];
		// Наличие хлебных крошек на этой странице
		$this->data['haveBreadcrumbs'] = false;

		// Уникальная пагинация для товаров
		$this->data['pagination'][0]['caption'] = $product['name'];

		// Проверка на наличие видеоиструкций(если их нет, то и блока не будет)
		$this->data['pagination'] = array_filter($this->data['pagination'], function ($elem) {
			return !($elem['anchor'] === 'b-videoInstructions' && ($this->data['videoInstructions']['html'] ?? "") === "");
		});

		$this->data['pagination'] = array_values($this->data['pagination']);

		return view('detail-product', $this->data);
	}

	/**
	 * Получение данных при клике на кнопку "Больше видео".
	 *
	 * Этот метод обрабатывает запрос на получение дополнительных видео, исключая уже загруженные
	 * видео по их идентификаторам. Он возвращает видео, если таковое имеется, и
	 * информацию о количестве оставшихся видео.
	 *
	 * @param \Illuminate\Http\Request $request Запрос, содержащий параметры для получения видео.
	 *
	 * @return \Illuminate\Http\JsonResponse JSON-ответ,
	 */
	public function getVideos(Request $request)
	{
		// Получаем уже загруженные ID из параметров запроса
		$fetchedIds = $request->query('ids', []);
		$limit = 3;

		if (is_string($fetchedIds) && !empty($fetchedIds)) {
			$fetchedIds = explode(',', $fetchedIds);
		} else {
			$fetchedIds = [];
		}
		//дополнительные видеоролики
		$additionalVideos = Video::select('id', 'name', 'preview', 'video', 'video_vk')
			->whereNotIn('id', $fetchedIds) // Исключаем уже загруженные ID
			->has('products')
			->distinct()
			->limit($limit)
			->get()
			->toArray();

		// Оставшееся количество
		$remainingCount = Video::select('id', 'name', 'videos')
			->whereNotIn('id', $fetchedIds)
			->has('products')
			->distinct()
			->count();

		return response()->json([
			'video' => $additionalVideos,
			'html' => $this->renderVideoHtml($additionalVideos) ?? '',
			'message' => $remainingCount <= $limit ? 'Все видео просмотрены или видео отсутствуют' : 'Видео ещё есть',
			'success' => $remainingCount <= $limit ? false : true,
		]);
	}

	/**
	 * Генерирует HTML для отображения видео.
	 *
	 * Этот метод принимает массив видео и создает HTML-код для каждого видео,
	 * используя представления для внутреннего и внешнего компонентов.
	 *
	 * @param array $videos Массив видео, где каждое видео должно содержать
	 *                      ключи 'video_vk', 'video', 'preview' и 'title'.
	 *
	 * @return string Сгенерированный HTML-код для отображения видео.
	 */
	public function renderVideoHtml($videos)
	{
		$html = '';
		$innerHtml = '';
		if (count($videos) === 0 || $videos === null) {
			$this->data['videoInstructions']['neededVideo'] = false;
			return;
		}

		foreach ($videos as $video) {
			// Генерируем HTML для внутреннего компонента
			$innerHtml = view('component.video', [
				'video_vk' => $video['video_vk'] === null ? null : $video['video_vk'],
				'video' => $video['video'],
				'preview' => $video['preview'] ? '/storage/' . $video['preview'] : '',
			])->render();

			// Генерируем HTML для внешнего компонента
			$html .= view('pages.detail-product.video-block', [
				'title' => $video['name'],
				'video' => $innerHtml,
			])->render();
		}

		return $html;
	}

	/**
	 * Подготовка мета данных
	 * 
	 * @param array $product Ассоциативный массив, представляющий родительский продукт,
	 * @param array $offer Ассоциативный массив, представляющий конкретный оффер,
	 * 
	 * @return void
	 */
	protected function prepareMeta($product, $offer)
	{
		$meta = [
			'title' => strip_tags(!empty($offer['meta_title']) ? $offer['meta_title'] : (!empty($product['meta_title']) ? $product['meta_title'] : ($product['name'] . " " . $offer['name']))),
			'description' => strip_tags(!empty($offer['meta_description']) ? $offer['meta_description'] : (!empty($product['meta_description']) ? $product['meta_description'] : explode('.', strip_tags($product['description']))[0] . '. ' . $product['name'] . '": ' . 'инструкция, техники введения, обучающее видео от экспертов Bellarti')),
			'keywords' => !empty($offer['meta_keywords']) ? $offer['meta_keywords'] : (!empty($product['meta_keywords']) ? $product['meta_keywords'] : 'Bellarti'),
		];

		$this->data['main_title'] = $product['name'];
		$this->data['seo_title'] = $meta['title'];
		$this->data['seo_description'] = $meta['description'];
		$this->data['seo_keywords'] = $meta['keywords'];
	}
}
