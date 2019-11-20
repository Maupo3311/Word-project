<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CrosswordWordRepository")
 */
class CrosswordWord
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Crossword
     * @ORM\OneToMany(targetEntity="Crossword", mappedBy="words")
     */
    private $crossword;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $wordName;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $wordCells;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getWordName(): string
    {
        return $this->wordName;
    }

    /**
     * @param string $wordName
     */
    public function setWordName(string $wordName): void
    {
        $this->wordName = $wordName;
    }

    /**
     * @return array
     */
    public function getWordCells(): array
    {
        return $this->wordCells;
    }

    /**
     * @param array $wordCells
     */
    public function setWordCells(array $wordCells): void
    {
        $this->wordCells = $wordCells;
    }

    /**
     * @return Crossword
     */
    public function getCrossword(): Crossword
    {
        return $this->crossword;
    }

    /**
     * @param Crossword $crossword
     */
    public function setCrossword(Crossword $crossword): void
    {
        $this->crossword = $crossword;
    }
}
