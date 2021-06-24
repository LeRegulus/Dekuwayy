<?php

namespace App\Controller;

use App\Entity\Anounce;
use App\Repository\AnounceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    /**
     * @var AnounceRepository
     */
    private $anounce;

    public function __construct(AnounceRepository $anounce)
    {
        $this->anounce = $anounce;
    }

    #[Route('/admin', name: 'admin_anounce_index')]
    public function index(): Response
    {
         $anounces = $this->anounce->findAll();
        return $this->render('admin/index.html.twig', [
            'anounces' => $anounces,
        ]);
    }

    #[Route('/admin/anonce/{id}', name: 'admin_anounce_edit')]
    #[ParamConverter('anounce', class: 'App\Entity\Anounce')]
    public function edit(Anounce $anounce): Response
    {
        return $this->render('admin/edit.html.twig', [
            'anounce' => $anounce,
        ]);
    }
}
