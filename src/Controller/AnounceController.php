<?php

namespace App\Controller;

use App\Entity\Anounce;
use App\Repository\AnounceRepository;
use Doctrine\ORM\Mapping\Id;
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

    #[Route('/anounce', name: 'anounce')]
    public function index(): Response
    {
        $anounces = $this->anounce->findAll();
        return $this->render('anounce/index.html.twig', [
            'anounces' => $anounces,
            'controller_name' => 'AnounceController',
        ]);
    }

    #[Route('/anounce/show/{id}', name: 'anounce_show')]
    #[ParamConverter('anounce', class: 'App\Entity\Anounce')]
    public function show(Anounce $anounce): Response
    {
        $anounce = $this->anounce->find($anounce);
        dump($anounce);
        return $this->render('anounce/show.html.twig', [
            'anounce' => $anounce,
            'controller_name' => 'AnounceController',
        ]);
    }

}
