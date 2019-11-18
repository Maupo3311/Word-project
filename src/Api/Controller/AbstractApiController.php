<?php

namespace Api\Controller;

use App\Service\WordService;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends FOSRestController
{
    /**
     * @param string $message A completion message.
     * @return Response
     */
    public function successResponse(string $message)
    {
        return new Response($message, 200);
    }

    /**
     * @param string $message A completion message.
     * @param int    $code    Error code.
     * @return Response
     */
    public function errorResponse(string $message, int $code)
    {
        return new Response($message, $code);
    }

    /**
     * @return WordService
     */
    protected function getWordService()
    {
        /** @var WordService $wordService */
        $wordService = $this->get('app.word_service');

        return $wordService;
    }
}
