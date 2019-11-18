<?php

namespace App\Service;

use App\Entity\Crossword;
use App\Entity\CrosswordWord;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class CrosswordGeneratorService
{
    /** @var string Crossword directory */
    protected $crosswordDir;

    /** @var EntityManager Doctrine entity manager. */
    protected $manager;

    /**
     * CrosswordGeneratorService constructor.
     * @param string        $projectDir Project kernel directory.
     * @param EntityManager $manager    Doctrine entity manager.
     */
    public function __construct(string $projectDir, EntityManager $manager)
    {
        $this->crosswordDir = "{$projectDir}/App/Materials/Crosswords";
        $this->manager      = $manager;
    }

    /**
     * @param array $config Crossword configuration.
     * @return Crossword
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createCrossword(array $config)
    {
        $crossword = (new Crossword())
            ->setLvl($config['lvl'])
            ->setHeight($config['height'])
            ->setWidth($config['width']);

        foreach ($config['words'] as $word => $position) {
            $crosswordWord = (new CrosswordWord())
                ->setCrossword($crossword)
                ->setPositions($position)
                ->setWord($word);

            $this->manager->persist($crosswordWord);
        }

        $this->manager->persist($crossword);
        $this->manager->flush();

        return $crossword;
    }
}
