<?php

namespace App\Controller;

use App\Entity\Anounce;
use App\Repository\AnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AnounceController extends AbstractController
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

    #[Route('/anounces', name: 'anounces_index')]
    public function index(): Response
    {
        $anounces = $this->anounce->find4();
        return $this->render('anounce/index.html.twig', [
            'anounces' => $anounces,
        ]);
    }

    #[Route('/anounce/show/{slug}', name: 'anounce_show')]
    #[ParamConverter('anounce', class: 'App\Entity\Anounce')]
    public function show(Anounce $anounce): Response
    {
        return $this->render('anounce/show.html.twig', [
            'anounce' => $anounce,
        ]);
    }

}
