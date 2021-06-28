<?php

namespace App\Controller;

use App\Entity\Anounce;
use App\Repository\AnounceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        $anounces = $this->anounce->findDisponible();
        return $this->render('home/index.html.twig', [
            'anounces' => $anounces,
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/anounce_home/{slug}/{id}', name: 'anounce__home_show')]
    #[ParamConverter('anounce', class: 'App\Entity\Anounce')]
    public function show(Anounce $anounce): Response
    {
        return $this->render('anounce/show.html.twig', [
            'anounce' => $anounce,
        ]);
    }
}
