<?php

namespace App\Controller;

use App\Entity\Anounce;
use App\Repository\AnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    public function __construct(AnounceRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        $anounces = $this->repository->findAll();
        return $this->render('admin/index.html.twig', [
            'anounces' => $anounces
        ]);
    }

    #[Route('/admin/edit/anounce/{id}', name: 'admin_anounce_edit')]
    public function edit(Anounce $anounce, Request $request): Response
    {
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash(type:'success', message:'Annonce modifiée avec succés!');
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/edit.html.twig', [
            'anounce' => $anounce,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/new_anounce/', name: 'admin_anounce_new')]
    public function new(Request $request):Response
    {
        $anounce = new Anounce();
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($anounce);
            $this->em->flush();
            $this->addFlash(type:'success', message:'Annonce crée avec succés!');
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/new.html.twig', [
            'anounce' => $anounce,
            'form' => $form->createView()
        ]);

    }

    #[Route('/admin/delete/anounce/{id}', name: 'admin_anounce_delete')]
    public function delete(Anounce $anounce){

        $this->em->remove($anounce);
        $this->em->flush();
        $this->addFlash(type:'success', message:'Annonce supprimée avec succés!');
        return $this->redirectToRoute('admin_index');
    }

}
