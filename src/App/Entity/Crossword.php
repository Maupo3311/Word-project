<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CrosswordRepository")
 */
class Crossword
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="CrosswordWord", mappedBy="crossword")
     */
    private $words;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $chars;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLvl(): int
    {
        return $this->lvl;
    }

    /**
     * @param int $lvl Crossword level.
     * @return $this
     */
    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width Crossword width.
     * @return $this
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height Crossword height.
     * @return $this
     */
    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @param ArrayCollection $words
     */
    public function setWords(ArrayCollection $words): void
    {
        $this->words = $words;
    }

    /**
     * @param CrosswordWord $word A CrosswordWord object.
     * @return $this
     */
    public function addWord(CrosswordWord $word): self
    {
        $this->words[] = $word;

        return $this;
    }

    /**
     * @return string
     */
    public function getChars(): string
    {
        return $this->chars;
    }

    /**
     * @param string $chars Crossword chars.
     * @return $this
     */
    public function setChars(string $chars): self
    {
        $this->chars = $chars;

        return $this;
    }

    /**
     * @return array
     */
    public function getInArray()
    {
        $inArray = [
            'lvl'    => $this->lvl,
            'width'  => $this->width,
            'height' => $this->height,
            'chars'  => $this->chars,
            'words'  => [],
        ];

        /** @var CrosswordWord $word */
        foreach ($this->words as $word) {
            $inArray['words'][] = [
                'wordName' => $word->getWordName(),
                'cells'    => $word->getWordCells(),
                'entered'  => false,
            ];
        }

        return $inArray;
    }
}
