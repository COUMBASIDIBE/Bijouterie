<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        for($i=1;$i<11;$i++):

            $article= new Article();// on instancie un nouvel objet herité de la class article App\entity\Article à chaque tout de boucle pour autant d'artice instancier il y'aura un insert supplementaire en BDD
           $article ->setNom("Article N°".$i)
                    ->setPrix (rand(100,400))
                    ->setDateCrea(new \DateTime())
                    ->setRef("ref :" .$i)
                    ->setPhoto('https://picsum.photos/600/
'.$i);
           //ici on "habille" nos objets nu instancier nu précédement avec les setters de nos diffèrentes proprietés hérités de notre objet articles entity


            $manager->persist($article);// persist est une methode issu de la class Objetmanager qui permet de garder en mémoire les objets articles crées précédement et de préparer et binder les requetes avant insertion

            endfor;

        $manager->flush();// flush est methode d'objectManager qui permet d'executer les requetes préparées par la methode persist et permet ainsi les insert en BDD

        // il fois realisé il faut charger les fixtures en BDD grace à Doctrine(ORM)
        //avec la commande suivante : php bin/console doctrine:fixtures:load



    }
}
