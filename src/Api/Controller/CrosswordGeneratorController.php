<?php

namespace Api\Controller;

use App\Entity\Crossword;
use App\Entity\CrosswordWord;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CrosswordGeneratorController
 * @package Api\Controller
 * @Rest\Route("/api/crossword", options={"expose"=true})
 */
class CrosswordGeneratorController extends AbstractApiController
{
    /**
     * @Rest\Post("/save", name="api_save_crossword")
     * @param Request $request A Request object.
     * @return Response
     */
    public function saveCrossword(Request $request)
    {
        try {
            $crosswordData = $request->request->get('crossword');

            $crossword = (new Crossword())
                ->setWidth($crosswordData['width'])
                ->setHeight($crosswordData['height'])
                ->setLvl($crosswordData['lvl'])
                ->setChars($crosswordData['chars']);

            /** @var EntityManager $manager */
            $manager = $this->getDoctrine()->getManager();
            foreach ($crosswordData['words'] as $word) {
                $crosswordWord = (new CrosswordWord())
                    ->setCrossword($crossword)
                    ->setWordCells($word['cells'])
                    ->setWordName($word['wordName']);

                $manager->persist($crosswordWord);
                $crossword->addWord($crosswordWord);
            }

            $manager->persist($crossword);
            $manager->flush();

            return $this->successResponse('Crossword successful created');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
