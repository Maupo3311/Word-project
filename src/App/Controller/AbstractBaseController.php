<?php

namespace App\Controller;

use App\Service\WordService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractBaseController extends Controller
{
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