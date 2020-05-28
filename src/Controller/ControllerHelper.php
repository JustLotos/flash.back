<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

trait ControllerHelper
{
    public function response(string $content, int $statusCode = Response::HTTP_OK): Response
    {
        return new Response($content, $statusCode);
    }

    public function getSimpleSuccessResponse()
    {
        return json_encode(['success' => true]);
    }
}
