<?php

namespace App\Controller\Crossword;

use App\Service\CrosswordGeneratorService;
use App\Service\WordService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractCrosswordController extends Controller
{
    /**
     * @return CrosswordGeneratorService
     */
    protected function getCrosswordGeneratorService()
    {
        /** @var CrosswordGeneratorService $crosswordGeneratorService */
        $crosswordGeneratorService = $this->get('app.crossword_generator_service');

        return $crosswordGeneratorService;
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