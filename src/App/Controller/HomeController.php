<?php

namespace App\Controller;

use App\Entity\Word;
use App\Repository\WordRepository;
use App\Service\DictionaryService;
use App\Service\WordService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/")
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('home/homepage.html.twig', []);
    }
}