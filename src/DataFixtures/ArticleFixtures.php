<?php

namespace App\DataFixtures;

use App\Entity\Artic;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i <= 15; $i++)
        {
            $artic = new Artic;

            $artic->setTitle("Titre de l'article n°$i")
                    ->setImage("https://picsum.photos/200/300")
                    ->setContent("<p>Contenu de l'article n°$i<p>")
                    ->setCreatedAt(new \Datetime());
                    $manager->persist($artic);

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
