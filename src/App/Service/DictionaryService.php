<?php

namespace App\Service;

class DictionaryService
{
    const DICTIONARIES = [
        0 => 'Dictionary.txt',
        1 => 'DictionaryWithDescription.txt',
    ];

    /** @var string Material directory */
    protected $materialDir;

    /**
     * DictionaryService constructor.
     * @param string $projectDir Project directory.
     */
    public function __construct(string $projectDir)
    {
        $this->materialDir = "{$projectDir}/src/App/Materials/Dictionary";
    }

    /**
     * Get an array of words read from the dictionary.
     * @return array
     */
    public function getWordsInArray()
    {
        $content = file_get_contents($this->getDictionaryPath(0));

        return explode("\r\n", $content);
    }

    /**
     * @return array
     */
    public function getWordWithDescriptionInArray()
    {
        $content = file_get_contents($this->getDictionaryPath(1));
        $contentInArray = explode("\r\n", $content);
        $words = [];
        foreach ($contentInArray as $row) {
            $regular = "/^([а-яА-Я]{3,})\|+[0-9]*(.+)\|+.+$/u";
            if (preg_match($regular, $row)) {
                $words[] = [
                    'name' => preg_replace($regular, '$1', $row),
                    'description' => str_ireplace('|', '', preg_replace($regular, '$2', $row)),
                ];
            }
        }

        return $words;
    }

    /**
     * @param int $dictionaryId Dictionary identifier.
     * @return string
     */
    private function getDictionaryPath(int $dictionaryId)
    {
        return "{$this->materialDir}/" . self::DICTIONARIES[$dictionaryId];
    }
}
