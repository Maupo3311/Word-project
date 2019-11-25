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
     * @ORM\ManyToOne(targetEntity="Crossword", inversedBy="words")
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
     * @param string $wordName Word name.
     * @return $this
     */
    public function setWordName(string $wordName): self
    {
        $this->wordName = $wordName;

        return $this;
    }

    /**
     * @return array
     */
    public function getWordCells(): array
    {
        return $this->wordCells;
    }

    /**
     * @param array $wordCells Crossword word cells.
     * @return $this
     */
    public function setWordCells(array $wordCells): self
    {
        $this->wordCells = $wordCells;

        return $this;
    }

    /**
     * @return Crossword
     */
    public function getCrossword(): Crossword
    {
        return $this->crossword;
    }

    /**
     * @param Crossword $crossword A crossword object.
     * @return $this
     */
    public function setCrossword(Crossword $crossword): self
    {
        $this->crossword = $crossword;

        return $this;
    }
}
