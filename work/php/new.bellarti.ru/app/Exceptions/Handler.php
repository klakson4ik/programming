<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use App\Http\Controllers\Error404Controller;
use App\Http\Controllers\Error500Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler
{
    public function __invoke(Exceptions $exceptions): Exceptions
    {
        $this->renderNotFound($exceptions);
        $this->renderServerError($exceptions);
        return $exceptions;
    }

    protected function renderNotFound(Exceptions $exceptions): void
    {
        $exceptions->renderable(
            function (NotFoundHttpException $e) {
				$controller = new Error404Controller();
				return $controller->index();
            }
        );
    }

    protected function renderServerError(Exceptions $exceptions): void
    {
        $exceptions->renderable(
            function (HttpException $e) {
                if ($e->getStatusCode() === 500) {
                    $controller = new Error500Controller();
                    return $controller->index();
                }
            }
        );
    }
}
