<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use MoonShine\Actions\ExportAction;
use MoonShine\Contracts\Resources\ResourceContract;
use MoonShine\Exceptions\ActionException;
use MoonShine\Jobs\ExportActionJob;
use MoonShine\Notifications\MoonShineNotification;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\InvalidArgumentException;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Writer\Exception\WriterNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class CostumExportService extends ExportAction
{

    public function handle(): RedirectResponse|BinaryFileResponse
    {
        if (is_null($this->resource())) {
            throw new ActionException('Resource is required for action');
        }

        $this->resolveStorage();

        $path = Storage::disk($this->getDisk())
            ->path("{$this->getDir()}/{$this->resource()->routeNameAlias()}.xlsx");

        if ($this->isQueue()) {
            ExportActionJob::dispatch(
                get_class($this->resource()),
                $path,
                $this->getDisk(),
                $this->getDir()
            );

            return back()
                ->with('alert', trans('moonshine::ui.resource.queued'));
        }

        return response()->download(
            self::process($path, $this->resource(), $this->getDisk(), $this->getDir())
        );
    }

    /**
     * @throws WriterNotOpenedException
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws InvalidArgumentException|Throwable
     */
    public static function process(
        string $path,
        ResourceContract $resource,
        string $disk = 'public',
        string $dir = '/'
    ): string {
        $fields = $resource->getFields()->exportFields();

        $items = $resource->resolveQuery()->get();


        $classiName = 'App\\Exports\\' . ucfirst($resource->getModel()->getTable()) . 'Export';
        $class = new $classiName();
        $data = $class->get($items, $fields);

        $header_style = (new Style())
        ->setBackgroundColor('EBEBEB')
        ->setFontBold();

        $result = (new FastExcel($data))
            ->headerStyle($header_style)
            ->export($path);

        $url = str($path)
            ->remove(Storage::disk($disk)->path($dir))
            ->value();

        MoonShineNotification::send(
            trans('moonshine::ui.resource.export.exported'),
            ['link' => Storage::disk($disk)->url(trim($dir, '/') . $url), 'label' => trans('moonshine::ui.download')]
        );

        return $result;
    }
}
