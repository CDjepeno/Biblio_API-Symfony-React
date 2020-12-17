<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Editor;
use App\Entity\Genre;
use App\Entity\Nationality;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker     = Factory::create('FR-fr');
        
        // Ont gère les éditeurs
        $editors = [];
        for($e=0; $e <= 10; $e++){
            $editor = new Editor;
            $editor->setFirstname($faker->firstname());

            $manager->persist($editor);

            $editors[] = $editor; 
        }   

        // Ont gère les nationalités
        $nationalities=['Russe','Espagnol','Américain','Français','Irlandais','Britanique','Allemand','Suedois','Italien','Japonais'];
        foreach($nationalities as $nat) {
            $nationality = new Nationality;

            $nationality->setTitle($nat);
            $manager->persist($nationality);
            
             // Ont gère les auteurs
             $authors = [];
             for($a=0; $a<=mt_rand(2,3); $a++){
                $author = new Author;
                $author->setFirstname($faker->firstname())
                        ->setLastname($faker->lastname())
                        ->setNationality($nationality);
                        
                $manager->persist($author);
                $authors[]= $author;
            }
            dd(count($authors));

           
        }
         // Ont gère les genres
         $genres = ['Litterature','Terreur','Science','BD','Policier'];
         foreach($genres as $g){
             $genre = new Genre;
             $genre->setTitle($g);

             $manager->persist($genre);

             // Ont gère les livres
             for($b=0; $b<=mt_rand(3,5); $b++){
                 $book = new Book;
                 $editor = $editors[mt_rand(0,count($editors) -1)];
                 $author = $authors[mt_rand(0,count($authors) -1)];
                 $book->setTitle('book'.$b)
                     ->setPrice(mt_rand(3, 7))
                     ->setIsbn(45)
                     ->setYear(mt_rand(1990,1995))
                     ->setLangue("italia")
                     ->setAuthor($author)
                     ->setEditor($editor)
                     ->setGenre($genre);

                $manager->persist($book);
             }
         }


        $manager->flush();
    }
}
