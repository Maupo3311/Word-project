<?php

namespace App\Service;

class DictionaryService
{
    const THE_NAME_OF_THE_DICTIONARY  = 'Dictionary';
    const EXPANSION_OF_THE_DICTIONARY = 'txt';

    /** @var string Material directory */
    protected $materialDir;

    /** @var string Dictionary file path */
    protected $dictionaryPath;

    /**
     * DictionaryService constructor.
     * @param string $projectDir Project directory.
     */
    public function __construct(string $projectDir)
    {
        $this->materialDir    = "{$projectDir}/src/Materials";
        $this->dictionaryPath = "{$this->materialDir}/" . self::THE_NAME_OF_THE_DICTIONARY . '.' . self::EXPANSION_OF_THE_DICTIONARY;
    }

    /**
     * Get an array of words read from the dictionary.
     * @return array
     */
    public function getWordsInArray()
    {
        $content = file_get_contents($this->dictionaryPath);
        return explode("\r\n", $content);
    }
}