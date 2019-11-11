<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordController
 * @package App\Controller
 * @Route("/word", options={"expose"=true})
 */
class WordController extends AbstractBaseController
{
    /**
     * @Route("/", name="word_generator")
     * @return Response
     */
    public function wordGenerator()
    {
        return $this->render('word/word_generator.html.twig');
    }

    /**
     * @Route("/get-by-char", name="word_get_by_chars")
     * @param Request $request A Request object.
     * @return JsonResponse|Response
     */
    public function getWordsOfTheCharacters(Request $request)
    {
        $charsInString = $request->query->get('chars');
        $charsInArray  = $this->getWordService()->getWordInArray($charsInString);
        $words         = $this->getWordService()->getWordByChars($charsInArray);

        return $this->render('word/partial_templates/generator_response.html.twig', [
            'words' => $words
        ]);
    }
}
