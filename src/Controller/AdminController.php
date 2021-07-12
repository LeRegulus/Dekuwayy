<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Anounce;
use App\Form\AnounceType;
use App\Form\UserEditFormType;
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

    #[Route('/admin/user', name: 'user_index')]
    public function user(){

        return $this->render('admin/user.html.twig');
    }


    #[Route('/admin/user/profil/{id}', name: 'user_edit_profil')]
    public function profilImage(User $user, Request $request): Response
    {
        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash(type:'success', message:'Annonce modifiée avec succés!');
            return $this->redirectToRoute('user_index');
        }
        return $this->render('admin/user_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/anounce', name: 'admin_anounce_index')]
    public function index(): Response
    {   
        $id = $this->getUser('id');
        $anounces = $this->repository->findUserAnounce($id);
        return $this->render('admin/index.html.twig', [
            'anounces' => $anounces
        ]);
    }

    #[Route('admin/anounce/new', name: 'admin_anounce_new')]
    public function new(Request $request): Response
    {
        $anounce = new Anounce();
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $anounce->setUser($this->getUser());
            $this->em->persist($anounce);
            $this->em->flush();
            $this->addFlash(type:'success', message:'Annonce crée avec succés!');
            return $this->redirectToRoute('anounce_index');
        }

        return $this->render('admin/new.html.twig', [
            'anounce' => $anounce,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/admin/anounce/edit/{slug}', name: 'admin_anounce_edit')]
    public function edit(Anounce $anounce, Request $request): Response
    {
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash(type:'success', message:'Annonce modifiée avec succés!');
            return $this->redirectToRoute('admin_anounce_index');
        }
        return $this->render('admin/edit.html.twig', [
            'anounce' => $anounce,
            'form' => $form->createView()
        ]);
    }


    #[Route('/admin/anounce/delete/{slug}', name: 'admin_anounce_delete')]
    public function delete(Anounce $anounce){
        $this->em->remove($anounce);
        $this->em->flush();
        $this->addFlash(type:'success', message:'Annonce supprimée avec succés!');
        return $this->redirectToRoute('admin_anounce_index');
    }

}
