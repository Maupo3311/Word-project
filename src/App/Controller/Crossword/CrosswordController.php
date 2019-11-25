<?php

namespace App\Controller\Crossword;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CrosswordController
 * @package App\Controller\Crossword
 * @Route("/crossword", options={"expose"=true})
 */
class CrosswordController extends AbstractCrosswordController
{
    /**
     * @Route("/game", name="crossword_game")
     * @return Response
     */
    public function game()
    {
        $crossword = $this->getCrosswordRepository()->find(1);

        return $this->render('crossword/game.html.twig', [
            'crossword'               => $crossword,
            'crossword_info_in_array' => $this->getCrosswordService()->getCrosswordInfoInArray($crossword),
        ]);
    }
}
