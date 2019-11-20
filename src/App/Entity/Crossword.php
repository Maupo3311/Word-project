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
     * @ORM\ManyToOne(targetEntity="CrosswordWord", inversedBy="crossword")
     */
    private $words;

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
     * @param int $lvl
     */
    public function setLvl(int $lvl): void
    {
        $this->lvl = $lvl;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return ArrayCollection
     */
    public function getWords(): ArrayCollection
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
}
