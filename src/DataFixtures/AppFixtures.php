<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Book;
use App\Entity\Role;
use App\Entity\Genre;
use App\Entity\Author;
use App\Entity\Editor;
use App\Entity\Member;
use App\Entity\BookRent;
use App\Entity\Nationality;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
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
           
            $Nationalities[]=$nationality;
        }
         // Ont gère les auteurs
         $authors = [];
         for($a=0; $a<=10; $a++){
            $author = new Author;
            $author->setFirstname($faker->firstname())
                    ->setLastname($faker->lastname())
                    ->setNationality($faker->randomElement($Nationalities));
                    
            $manager->persist($author);
            $authors[]= $author;
        }
         // Ont gère les genres
         $genres = ['Litterature','Terreur','Science','BD','Policier'];
         $languages = ['french','italia','spanish','english','german'];

         
         foreach($genres as $g){
             $genre = new Genre;
             $genre->setTitle($g);
             
             $manager->persist($genre);
             
             // Ont gère les livres
             for($b=0; $b<=mt_rand(3,5); $b++){
                 $book = new Book;
                 $editor = $editors[mt_rand(0,count($editors) -1)];
                 $author = $authors[mt_rand(0,count($authors) -1)];
                 $book->setTitle($faker->name())
                     ->setPrice(mt_rand(3, 7))
                     ->setIsbn(45)
                     ->setYear(mt_rand(1990,1995))
                     ->setPicture("https://picsum.photos/id/237/200/300")
                     ->setAuthor($author)
                     ->setEditor($editor)
                     ->setGenre($genre);
                     foreach($languages as $l) {
                        $book->setLangue($l);          
                     }
                $books[]=$book;
                $manager->persist($book);
             }
         }

        //  Ont gère les membres
        for($m=0; $m<25; $m++){
            $member  = new Member();
            $commune = ["78003", "78005", "78006", "78007", "78009", "78010", "78013", "78015", "78020", "78029",
            "78030", "78031", "78033", "78034", "78036", "78043", "78048", "78049", "78050", "78053", "78057",
            "78062", "78068", "78070", "78071", "78072", "78073", "78076", "78077", "78082", "78084", "78087",
            "78089", "78090", "78092", "78096", "78104", "78107", "78108", "78113", "78117", "78118"];
            $hash    = $this->encoder->encodePassword($member, 'password');
            $member->setFirstname($faker->firstname())
                   ->setLastname($faker->lastname())
                   ->setAddress($faker->streetaddress())
                   ->setCommuneCode($commune[mt_rand(0,sizeof($commune)-1)])
                   ->setMail(strtolower($member->getFirstname()."@mail.com"))
                   ->setPhone($faker->phoneNumber())
                   ->setPassword($hash);

            $members[] = $member;
            $manager->persist($member);
        }
        // Ont gère les roles
        $adminRole = new Role();
        $adminRole->setTitle("ROLE_ADMIN");
        $manager->persist($adminRole);

        $member = new member();
        $member->setFirstname("chris")
        ->setLastname("djepeno")
        ->setMail("admin@gmail.com")
        ->setPassword($this->encoder->encodePassword($member, "admin"))
        ->addRole($adminRole);
        //  dd($member->getRoles());
        $manager->persist($member);

        $managerRole = new Role();
        $managerRole->setTitle("ROLE_MANAGER");
        $manager->persist($managerRole);

        $member = new member();
        $member->setFirstname("sonia")
                ->setLastname("djepeno")
                ->setMail("manager@gmail.com")
                ->setPassword($this->encoder->encodePassword($member, "manager"))
                ->addRole($managerRole);
        $manager->persist($member);

         //  Ont gère les locations de livre
         for($i=0; $i<25; $i++){
             $max = mt_rand(1,5);
             for($r=0;$r<=$max;$r++){
                $bookrent    = $faker->randomElement($books);
                $memberrent  = $faker->randomElement($members);
                $rent        = new BookRent();
                $dateRent    = $faker->dateTimeBetween('-6 months');
                $duration1   = 15;
                $duration2   = mt_rand(20, 25);

                // Ont clone la dateRent pour ne pas modifier la startDate.
                $dateReturn      = (clone $dateRent)->modify("+$duration1 days");
                $dateRealReturn  = (clone $dateRent)->modify("+$duration2 days");

                $rent->setBook($bookrent)
                     ->setMember($memberrent)
                     ->setDateRent($dateRent)
                     ->setDateReturn($dateReturn);
                     if(mt_rand(1,3)==1){
                         $rent->setDateRealReturn($dateRealReturn);
                     }      
                $manager->persist($rent);
            }
        }
        $manager->flush();
    }
}
