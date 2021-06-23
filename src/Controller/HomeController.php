<?php

namespace App\Controller;

use App\Repository\AnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{   
    /**
     * Undocumented variable
     *
     * @var AnounceRepository
     */
    private $anounce;

    public function __construct(AnounceRepository $anounce)
    {
        $this->anounce = $anounce;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {   
        $anounces = $this->anounce->find4();
        return $this->render('home/index.html.twig', [
            'anounces' => $anounces,
            'controller_name' => 'HomeController',
        ]);
    }
}
