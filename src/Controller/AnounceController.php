<?php

namespace App\Controller;

use App\Entity\Anounce;
use App\Form\AnounceType;
use App\Repository\AnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/anounce')]
class AnounceController extends AbstractController
{
    #[Route('/', name: 'anounce_index', methods: ['GET'])]
    public function index(AnounceRepository $anounceRepository): Response
    {
        return $this->render('anounce/index.html.twig', [
            'anounces' => $anounceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'anounce_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $anounce = new Anounce();
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($anounce);
            $entityManager->flush();

            return $this->redirectToRoute('anounce_index');
        }

        return $this->render('anounce/new.html.twig', [
            'anounce' => $anounce,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'anounce_show', methods: ['GET'])]
    public function show(Anounce $anounce): Response
    {
        return $this->render('anounce/show.html.twig', [
            'anounce' => $anounce,
        ]);
    }

    #[Route('/{id}/edit', name: 'anounce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Anounce $anounce): Response
    {
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('anounce_index');
        }

        return $this->render('anounce/edit.html.twig', [
            'anounce' => $anounce,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'anounce_delete', methods: ['POST'])]
    public function delete(Request $request, Anounce $anounce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anounce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($anounce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('anounce_index');
    }
}
