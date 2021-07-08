<?php

namespace App\Controller;

use App\Entity\Anounce;
use App\Entity\Comment;
use App\Form\AnounceType;
use App\Form\CommentType;
use App\Repository\AnounceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/{slug}', name: 'anounce_show')]
    public function show(Anounce $anounce, Request $request): Response
    {   
        $comment = new Comment();
        $commentform = $this->createForm(CommentType::class, $comment);
        $commentform->handleRequest($request);
        if ($commentform->isSubmitted() && $commentform->isValid()) {
            $comment->setCreatedAt(new DateTime());
            $anounce->addComment($comment);
            $this->em->persist($comment);
            $this->em->flush();
            $this->addFlash(type:'success', message:'Commentaire posté avec succés!');
            return $this->redirectToRoute('anounce_show', array('slug'=> $anounce->getSlug()));
        }
        return $this->render('anounce/show.html.twig', [
            'commentform' => $commentform->createView(),
            'anounce' => $anounce,
        ]);
    }

}
