<?php

namespace App\Controller;

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

    #[Route('/anounce', name: 'anounce')]
    public function index(): Response
    {
        return $this->render('anounce/index.html.twig', [
            'controller_name' => 'AnounceController',
        ]);
    }

    /**
     * @Route(/anounce/show/{id}', name='anounce_show')
     * @ParamConverter('anounce', class='App\Entity\Anounce, options={"mapping": {"anounce_id": "id"}}')
     */
    /*public function show($id, $anounce): Response
    {
        //$anounces = $this->anounce->findBY($id);
        return $this->render('anounce/show.html.twig', [
            'anounce' => $anounce,
            'controller_name' => 'AnounceController',
        ]);
    }*/
}
