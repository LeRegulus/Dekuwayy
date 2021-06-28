<?php

namespace App\DataFixtures;

use App\Entity\Anounce;
use App\Entity\Comment;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Cocur\Slugify\Slugify;

class AppFixtures extends Fixture
{
    
    public function load(ObjectManager $em)
    {   


        $faker = Factory::create('fr_FR');
        $slugger= new Slugify();

        for ($i=0; $i<15; $i++){
            $anounce = new Anounce();
            $anounce->setTitle($faker->sentence(3, false))
                ->setDesription($faker->text(100))
                ->setPrice(mt_rand(30000, 60000))
                ->setAddress($faker->address())
                ->setCoverImage('https://picsum.photos/1200/500/?random='.mt_rand(1, 10000))
                ->setRooms(mt_rand(2, 5))
                ->setIsAvailable(mt_rand(0, 1))
                ->setCreatedAt($faker->dateTimeBetween('-3 month', 'now'))
                ->setIntro($faker->sentence(3, false));

                for($j=0; $j<mt_rand(1, 7); $j++){
                    $comment = new Comment();
                    $comment->setAuthor($faker->name())
                        ->setMail($faker->email())
                        ->setContent($faker->text(200))
                        ->setCreatedAt($faker->dateTimeBetween('-3 month', 'now'))
                        ->setAnounce($anounce);
                    //$em->persist($comment);
                    $anounce->addComment($comment);
                }
                for($k=0; $k<mt_rand(1, 5); $k++){
                    $image= new Image();
                    $image->setImageUrl('https://picsum.photos/300/300/?random='.mt_rand(1, 10000))
                        ->setDescription($faker->sentence(3, False))
                        ->setAnounce($anounce);
                    //$em->persist($image);
                    $anounce->addImage($image);
                }

            $em->persist($anounce);
          }
          

        $em->flush();
    }
}
