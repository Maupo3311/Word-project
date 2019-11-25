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

        $inCrossword    = [];
        $notInCrossword = [];
        /** @var Word $word */
        foreach ($allWord as $word) {
            $isInCrossword = false;
            /** @var CrosswordWord $crosswordWord */
            foreach ($crossword->getWords() as $crosswordWord) {
                if ($crosswordWord->getWordName() === $word->getName()) {
                    $isInCrossword = true;
                    continue;
                }
            }

            $wordInArray = [
                'wordName'    => $word->getName(),
                'description' => $word->getDescription(),
                'entered'     => false,
            ];
            if ($isInCrossword) {
                $inCrossword[] = $wordInArray;
            } else {
                $notInCrossword[] = $wordInArray;
            }
        }

        $crosswordInArray = $crossword->getInArray();
        $crosswordInArray['words_info'] = [
            'in'     => $inCrossword,
            'not_in' => $notInCrossword,
        ];

        return $crosswordInArray;
    }
}
