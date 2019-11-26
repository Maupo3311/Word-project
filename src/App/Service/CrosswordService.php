<?php

namespace App\Service;

use App\Entity\Crossword;
use App\Entity\CrosswordWord;
use App\Entity\Word;

/**
 * Class CrosswordService
 * @package App\Service
 */
class CrosswordService
{
    /** @var WordService A Word service */
    private $wordService;

    /**
     * CrosswordService constructor.
     * @param WordService $wordService A Word service class.
     */
    public function __construct(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    /**
     * @param Crossword $crossword A Crossword object.
     * @return array
     */
    public function getCrosswordInfoInArray(Crossword $crossword)
    {
        $charsInArray = $this->wordService->getWordInArray($crossword->getChars());
        $allWord      = $this->wordService->getWordByChars($charsInArray);

        $words = [];
        $wordsInCrossword = 0;
        /** @var Word $word */
        foreach ($allWord as $word) {
            $lastCrosswordWord = null;
            /** @var CrosswordWord $crosswordWord */
            foreach ($crossword->getWords() as $crosswordWord) {
                if ($crosswordWord->getWordName() === $word->getName()) {
                    $lastCrosswordWord = $crosswordWord;
                    $wordsInCrossword++;
                    break;
                }
            }

            $words[] =  [
                'wordName'    => $word->getName(),
                'description' => $word->getDescription(),
                'entered'     => false,
                'inCrossword' => $lastCrosswordWord !== null ? true : false,
                'cells'       => $lastCrosswordWord === null ?: $lastCrosswordWord->getWordCells(),
            ];
        }

        $crosswordInArray = $crossword->getInArray();
        $crosswordInArray['words'] = $words;
        $crosswordInArray['wordsInCrossword'] = $wordsInCrossword;

        return $crosswordInArray;
    }
}
