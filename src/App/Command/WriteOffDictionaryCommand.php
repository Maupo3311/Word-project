<?php

namespace App\Command;

use App\Entity\Word;
use App\Service\DictionaryService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WriteOffDictionaryCommand extends Command
{
    /** @var EntityManager Doctrine entity manager. */
    protected $manager;

    /** @var DictionaryService Service for work with dictionary. */
    protected $dictionaryService;

    /**
     * WriteOffDictionaryCommand constructor.
     * @param DictionaryService $dictionaryService Service for work with dictionary.
     * @param EntityManager     $manager           Doctrine entity manager.
     */
    public function __construct(DictionaryService $dictionaryService, EntityManager $manager)
    {
        $this->dictionaryService = $dictionaryService;
        $this->manager           = $manager;

        parent::__construct(null);
    }

    /**
     * Configuration command.
     */
    protected function configure()
    {
        $this->setName('app:write-off-dictionary')
            ->setDescription('Reads the dictionary located in the materials and writes the results to the database.');
    }

    /**
     * @param InputInterface  $input  Input command.
     * @param OutputInterface $output Output command.
     * @return int|void|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $words = $this->dictionaryService->getWordWithDescriptionInArray();

        $lastWord = new Word('');
        foreach ($words as $word) {
            if ($lastWord->getName() === $word['name']) {
                $newDescription = "{$lastWord->getDescription()}. Или {$word['description']}";
                $lastWord->setDescription($newDescription);
            } else {
                $lastWord = (new Word($word['name']))->setDescription($word['description']);
            }
            $this->manager->persist($lastWord);
        }

        $this->manager->flush();
    }
}