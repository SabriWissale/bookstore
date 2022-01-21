<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Genre;
use App\Entity\Auteur;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Faker\Factory::create();
       
        for($i=0; $i<5; $i++)
        {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword($faker->password);
            if($i == 1)
            {
                $user->setRole('ROLE_ADMIN');
            }
            else
            {
                $user->setRole('ROLE_USER');
            }
            $manager->persist($user);
 
        }
        
       
        $genres = []; 
        for($i=0; $i<10; $i++)
        {
            $genre = new Genre();
            $genre->setNom($faker->unique()->word);
            $genres[] = $genre;
        }
        //----------------
        $auteurs = []; 
        for($i=0; $i<20; $i++)
        {
            $auteur = new Auteur();
            $auteur->setNomPrenom($faker->unique()->name);
            $auteur->setSexe($faker->randomElement($array = array ('M','F')));
            $auteur->setDateNaissance($faker->dateTime($max = 'now', $timezone = null));
            $auteur->setNationalite($faker->country);
            $auteurs[] = $auteur;  
        }

        //--------------
        $livres = [];
        for($i=0; $i<50; $i++)
        {
            $livre = new Livre();
            $livre->setIsbn($faker->isbn13);
            $livre->setTitre($faker->unique()->name);
            $livre->setNombrePages($faker->numberBetween(10, 500));
            $livre->setDateDeParution($faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = null));
            $livre->setNote($faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 20));

            for($j=0; $j< $faker->numberBetween($min = 1, $max = 3); $j++)
            {
                    $nb = $faker->numberBetween(0, 4);
                    $genre = $genres[$nb];
                    //$genre = $faker->unique()->randomElement($genres);
                    $livre->addGenre($genre);
                    
            }

            for($j=0; $j< $faker->numberBetween($min = 1, $max = 3); $j++)
            {
                $nb = $faker->numberBetween(0, 19);
                $auteur = $auteurs[$nb];
               //$auteur = $faker->unique()->randomElement($auteurs);
               $livre->addAuteur($auteur);
               
                    
            }
             
             $livres[] = $livre; 
            
            
        }
        
        //----------PERSIST ALL ENTITIES-----
        for($i=0; $i<sizeof($auteurs); $i++)
        {
            $manager->persist($auteurs[$i]);
        }
        for($i=0; $i<sizeof($genres); $i++)
        {
            $manager->persist($genres[$i]);
        }
        for($i=0; $i<sizeof($livres); $i++)
        {
            $manager->persist($livres[$i]);
        }
        
      
        


        $manager->flush();

    }
}
