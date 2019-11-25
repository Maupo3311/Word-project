<?php

namespace App\Service;

use App\Entity\Word;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class WordService
 * @package App\Service
 */
class WordService
{
    /** @var EntityManager */
    protected $manager;

    /**
     * WordService constructor.
     * @param EntityManager $manager Doctrine entity manager.
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param array $chars  Chars from which to make a word.
     * @param array $params Parameters.
     * @return array
     */
    public function getWordByChars(array $chars, $params = [])
    {
        /** @var WordRepository $wordRepository */
        $wordRepository = $this->manager->getRepository(Word::class);
        $words          = $wordRepository->findWithChars($chars, $this->getSubQueries($chars));

        return $this->filterWords($words, $chars);
    }

    /**
     * @param string $word Word.
     * @return array
     */
    public function getWordInArray(string $word)
    {
        return preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);
    }

    /*********************************************************
     *                   Private methods
     *********************************************************/

    /**
     * @param integer $position Current position for char.
     * @param integer $length   Word length.
     * @return string
     */
    private function getLikePosition(int $position, int $length)
    {
        $likePosition = '';

        for ($count = 0; $count < $length; ++$count) {
            if ($count === $position) {
                $likePosition .= 'S';
            } else {
                $likePosition .= '_';
            }
        }

        return $likePosition;
    }

    /**
     * @param array  $chars        Chars from which to make a word.
     * @param string $likePosition The string for the query.
     * @return false|string
     */
    private function createSubQuery(array $chars, string $likePosition)
    {
        $subQuery = '(';
        foreach ($chars as $char) {
            $like     = str_replace('S', $char, $likePosition);
            $subQuery .= "w.name LIKE '{$like}' OR ";
        }

        $subQuery = substr($subQuery, 0, -4);
        $subQuery .= ')';

        return $subQuery;
    }

    /**
     * @param array $chars Chars from which to make a word.
     * @return array
     */
    private function getSubQueries(array $chars)
    {
        $subQueries = [];
        for ($length = count($chars); $length >= 3; --$length) {
            for ($position = 0; $position < $length; ++$position) {
                $likePosition          = $this->getLikePosition($position, $length);
                $subQueries[$length][] = $this->createSubQuery($chars, $likePosition);
            }
        }

        return $this->ToGroupTheSubQueries($subQueries);
    }

    /**
     * @param array $subQueries SubQueries.
     * @return array
     */
    private function ToGroupTheSubQueries(array $subQueries)
    {
        $groupedQueries = [];
        foreach ($subQueries as $length => $subQueryInArray) {
            $groupedQuery = '(';
            foreach ($subQueryInArray as $subQuery) {
                $groupedQuery .= "{$subQuery} AND ";
            }
            $groupedQuery     = substr($groupedQuery, 0, -5);
            $groupedQuery     .= ')';
            $groupedQueries[] = $groupedQuery;
        }

        return $groupedQueries;
    }

    /**
     * @param array $words Array of words to filter (Not objects).
     * @param array $chars The characters specified by the user.
     * @return array
     */
    private function filterWords(array $words, array $chars)
    {
        $charsQuantity = $this->getTheNumberOfCharacters(implode('', $chars));
        $filterWords   = [];
        foreach ($words as $word) {
            $wordCharQuantity = $this->getTheNumberOfCharacters($word->getName());
            if ($this->isSimilarity($charsQuantity, $wordCharQuantity)) {
                $filterWords[] = $word;
            }
        }

        return $filterWords;
    }

    /**
     * @param array $charQuantity     Quantity of user-defined characters.
     * @param array $wordCharQuantity Quantity of characters in a word.
     * @return bool
     */
    private function isSimilarity(array $charQuantity, array $wordCharQuantity)
    {
        foreach ($wordCharQuantity as $char => $quantity) {
            if ($quantity > $charQuantity[$char]) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $string String from which we get the number of characters.
     * @return array
     */
    private function getTheNumberOfCharacters(string $string)
    {
        $charsQuantity = [];
        for ($count = 0; $count < strlen($string); ++$count) {
            $char = $string[$count];
            if (empty($charsQuantity[$char])) {
                $charsQuantity[$char] = 1;
            } else {
                $charsQuantity[$char] += 1;
            }
        }

        return $charsQuantity;
    }
}
