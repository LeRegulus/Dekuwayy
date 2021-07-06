<?php

namespace App\Controller;

use App\Entity\Anounce;
use App\Entity\Comment;
use App\Form\AnounceType;
use App\Form\CommentType;
use App\Repository\AnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/anounce')]
class AnounceController extends AbstractController
{   
    public function __construct(AnounceRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    #[Route('/', name: 'anounce_index', methods: ['GET'])]
    public function index(): Response
    {   
        $anounces = $this->repository->findOrder();
        return $this->render('anounce/index.html.twig', [
            'anounces' => $anounces,
        ]);
    }

    #[Route('/new', name: 'anounce_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $anounce = new Anounce();
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($anounce);
            $this->em->flush();
            $this->addFlash(type:'success', message:'Annonce crée avec succés!');
            return $this->redirectToRoute('anounce_index');
        }

        return $this->render('anounce/new.html.twig', [
            'anounce' => $anounce,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'anounce_show', methods: ['GET'])]
    public function show(Anounce $anounce, Request $request): Response
    {   
        $comment = new Comment();
        $commentform = $this->createForm(CommentType::class, $comment);
        $commentform->handleRequest($request);
        if ($commentform->isSubmitted() && $commentform->isValid()) {
            $comment->setAnounce($anounce);
            $this->em->persist($comment);
            $this->em->flush();
            $this->addFlash(type:'success', message:'Commentaire posté avec succés!');
            return $this->redirectToRoute('anounce_index');
        }
        return $this->render('anounce/show.html.twig', [
            'commentform' => $commentform->createView(),
            'anounce' => $anounce,
        ]);
    }

    #[Route('/{id}/edit', name: 'anounce_edit', methods: ['GET', 'POST'])]
    public function edit(Anounce $anounce, Request $request): Response
    {
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash(type:'success', message:'Annonce modifiée avec succés!');
            return $this->redirectToRoute('anounce_index');
        }

        return $this->render('anounce/edit.html.twig', [
            'anounce' => $anounce,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'anounce_delete', methods: ['POST'])]
    public function delete(Anounce $anounce, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anounce->getId(), $request->request->get('_token'))) {
            $this->em->remove($anounce);
            $this->em->flush();
        }
        $this->addFlash(type:'success', message:'Annonce supprimée avec succés!');
        return $this->redirectToRoute('anounce_index');
    }
}
