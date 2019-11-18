<?php

namespace Api\Controller;

use App\Entity\Word;
use App\Repository\WordRepository;
use App\Service\WordService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class WordController
 * @package Api\Controller
 * @Rest\Route("/api/word", options={"expose"=true})
 */
class WordController extends AbstractApiController
{
    /**
     * @Rest\Get("/get-by-chars", name="word_get_by_chars")
     * @param Request $request A Request object.
     * @return Response
     */
    public function getWordsOfTheCharactersTemplate(Request $request)
    {
        $charsInString = mb_strtolower($request->query->get('chars'));
        $charsInArray  = $this->getWordService()->getWordInArray($charsInString);
        $words         = $this->getWordService()->getWordByChars($charsInArray);

        $view = $this->view($words, 200);
        return $this->handleView($view);
    }
}