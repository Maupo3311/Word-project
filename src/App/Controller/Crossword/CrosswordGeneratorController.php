<?php

namespace App\Controller\Crossword;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CrosswordGeneratorController
 * @package App\Controller\Crossword
 * @Route("/generator/crossword", options={"expose"=true})
 */
class CrosswordGeneratorController extends AbstractCrosswordController
{
    /**
     * @Route("/page", name="crossword_generator_page")
     * @return Response
     */
    public function index()
    {
        return $this->render('crossword/generator/index.html.twig');
    }

    /**
     * @Route("/get-markup", name="crossword_generator_get_markup")
     * @param Request $request A Request object.
     * @return Response
     */
    public function getCrosswordMarkup(Request $request)
    {
        return $this->render('crossword/generator/partial_templates/crossword.html.twig', [
            'width'  => $request->query->get('width'),
            'height' => $request->query->get('height'),
        ]);
    }

    /**
     * @Route("/get-word-for-generate", name="crossword_generator_get_word")
     * @param Request $request A Request object.
     * @return Response
     */
    public function getWordsForGenerate(Request $request)
    {
        $charsInString = mb_strtolower($request->query->get('chars'));
        $charsInArray  = $this->getWordService()->getWordInArray($charsInString);
        $words         = $this->getWordService()->getWordByChars($charsInArray);

        return $this->render('crossword/generator/partial_templates/word_for_generate.html.twig', [
            'words' => $words,
        ]);
    }
}
