<?php

namespace App\Controller;

use Faker\Factory;
use App\Entity\Image;
use App\Entity\Anounce;
use App\Entity\Comment;
use App\Form\AnounceType;
use App\Repository\AnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdminController extends AbstractController
{
    /**
     * @var AnounceRepository
     */
    private $anounce;

    private $em;

    public function __construct(AnounceRepository $anounce, EntityManagerInterface $em)
    {
        $this->anounce = $anounce;
        $this->em = $em;
    }

    #[Route('/admin', name: 'admin_anounce_index')]
    public function index(): Response
    {
         $anounces = $this->anounce->findAll();
        return $this->render('admin/index.html.twig', [
            'anounces' => $anounces,
        ]);
    }

    #[Route('/admin/edit/anounce/{id}', name: 'admin_anounce_edit')]
    #[ParamConverter('anounce', class: 'App\Entity\Anounce')]
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

    #[Route('/admin/new_anounce/', name: 'admin_anounce_new')]
    public function new(Request $request):Response
    {
        $faker = Factory::create('fr_FR');
        $anounce = new Anounce();
        $form = $this->createForm(AnounceType::class, $anounce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $anounce->setCoverImage('https://picsum.photos/1200/500/?random='.mt_rand(1, 10000));
            for($j=0; $j<mt_rand(1, 7); $j++){
                $comment = new Comment();
                $comment->setAuthor($faker->name())
                    ->setMail($faker->email())
                    ->setContent($faker->text(200))
                    ->setCreatedAt($faker->dateTimeBetween('-3 month', 'now'))
                    ->setAnounce($anounce);
                $this->em->persist($comment);
                $anounce->addComment($comment);
            }
            for($k=0; $k<mt_rand(1, 5); $k++){
                $image= new Image();
                $image->setImageUrl('https://picsum.photos/300/300/?random='.mt_rand(1, 10000))
                    ->setDescription($faker->sentence(3, False))
                    ->setAnounce($anounce);
                $this->em->persist($image);
                $anounce->addImage($image);
            }
            $this->em->persist($anounce);
            $this->em->flush();
            $this->addFlash(type:'success', message:'Annonce crée avec succés!');
            return $this->redirectToRoute('admin_anounce_index');
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
        $this->addFlash(type:'success', message:'Annonce suppeimée avec succés!');
        return $this->redirectToRoute('admin_anounce_index');
    }
     
}
