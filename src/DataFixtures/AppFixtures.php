<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $names = array('Allison',
            'Arthur', 'Ana',
            'Alex', 'Arlene',
            'Alberto', 'Barry',
            'Bertha', 'Bill',
            'Bonnie', 'Bret',
            'Beryl', 'Chantal',
            'Cristobal', 'Claudette',
            'Charley', 'Cindy',
            'Chris', 'Dean',
            'Dolly', 'Danny',
            'Danielle', 'Dennis',
            'Debby', 'Erin',
            'Edouard', 'Erika',
            'Earl', 'Emily',
            'Ernesto', 'Felix',
            'Fay', 'Fabian',
            'Frances', 'Franklin',
            'Florence', 'Gabielle',
            'Gustav', 'Grace',
            'Gaston', 'Gert',
            'Gordon', 'Humberto',
            'Hanna', 'Henri',
            'Hermine', 'Harvey',
            'Helene', 'Iris',
            'Isidore', 'Isabel',
            'Ivan', 'Irene',
            'Isaac', 'Jerry',
            'Josephine',
            'Juan',
            'Jeanne',
            'Jose',
            'Joyce',
            'Karen',
            'Kyle',
            'Kate',
            'Karl',
            'Katrina',
            'Kirk',
            'Lorenzo',
            'Lili',
            'Larry',
            'Lisa',
            'Lee',
            'Leslie',
            'Michelle',
            'Marco',
            'Mindy',
            'Maria',
            'Michael',
            'Noel',
            'Nana',
            'Nicholas',
            'Nicole',
            'Nate',
            'Nadine',
            'Olga',
            'Omar',
            'Odette',
            'Otto',
            'Ophelia',
            'Oscar',
            'Pablo',
            'Paloma',
            'Peter',
            'Paula',
            'Philippe',
            'Patty',
            'Rebekah',
            'Rene',
            'Rose',
            'Richard',
            'Rita',
            'Rafael',
            'Sebastien',
            'Sally',
            'Sam',
            'Shary',
            'Stan',
            'Sandy',
            'Tanya',
            'Teddy',
            'Teresa',
            'Tomas',
            'Tammy',
            'Tony',
            'Van',
            'Vicky',
            'Victor',
            'Virginie',
            'Vince',
            'Valerie',
            'Wendy',
            'Wilfred',
            'Wanda',
            'Walter',
            'Wilma',
            'William',
            'Kumiko',
            'Aki',
            'Miharu',
            'Chiaki',
            'Michiyo',
            'Itoe',
            'Nanaho',
            'Reina',
            'Emi',
            'Yumi',
            'Ayumi',
            'Kaori',
            'Sayuri',
            'Rie',
            'Miyuki',
            'Hitomi',
            'Naoko',
            'Miwa',
            'Etsuko',
            'Akane',
            'Kazuko',
            'Miyako',
            'Youko',
            'Sachiko',
            'Mieko',
            'Toshie',
            'Junko');
        $surnames = array("Anderson", "Ashwoon", "Aikin", "Bateman", "Bongard", "Bowers", "Boyd", "Cannon", "Cast", "Deitz", "Dewalt", "Ebner", "Frick", "Hancock", "Haworth", "Hesch", "Hoffman", "Kassing", "Knutson", "Lawless", "Lawicki", "Mccord", "McCormack", "Miller", "Myers", "Nugent", "Ortiz", "Orwig", "Ory", "Paiser", "Pak", "Pettigrew", "Quinn", "Quizoz", "Ramachandran", "Resnick", "Sagar", "Schickowski", "Schiebel", "Sellon", "Severson", "Shaffer", "Solberg", "Soloman", "Sonderling", "Soukup", "Soulis", "Stahl", "Sweeney", "Tandy", "Trebil", "Trusela", "Trussel", "Turco", "Uddin", "Uflan", "Ulrich", "Upson", "Vader", "Vail", "Valente", "Van Zandt", "Vanderpoel", "Ventotla", "Vogal", "Wagle", "Wagner", "Wakefield", "Weinstein", "Weiss", "Woo", "Yang", "Yates", "Yocum", "Zeaser", "Zeller", "Ziegler", "Bauer", "Baxster", "Casal", "Cataldi", "Caswell", "Celedon", "Chambers", "Chapman", "Christensen", "Darnell", "Davidson", "Davis", "DeLorenzo", "Dinkins", "Doran", "Dugelman", "Dugan", "Duffman", "Eastman", "Ferro", "Ferry", "Fletcher", "Fietzer", "Hylan", "Hydinger", "Illingsworth", "Ingram", "Irwin", "Jagtap", "Jenson", "Johnson", "Johnsen", "Jones", "Jurgenson", "Kalleg", "Kaskel", "Keller", "Leisinger", "LePage", "Lewis", "Linde", "Lulloff", "Maki", "Martin", "McGinnis", "Mills", "Moody", "Moore", "Napier", "Nelson", "Norquist", "Nuttle", "Olson", "Ostrander", "Reamer", "Reardon", "Reyes", "Rice", "Ripka", "Roberts", "Rogers", "Root", "Sandstrom", "Sawyer", "Schlicht", "Schmitt", "Schwager", "Schutz", "Schuster", "Tapia", "Thompson", "Tiernan", "Tisler");

        shuffle($names);
        shuffle($surnames);
        for ($i = 0; $i < 20; $i++) {
            $product = new Participant();
            $site1=$this->getReference(SiteFixtures::SITE_REFERENCE1);
            $site2=$this->getReference(SiteFixtures::SITE_REFERENCE2);
            $array = [0=>$site1,1=>$site2];
            switch ($i%2){
                case 0: $site=$array[0];break;
                case 1 : $site=$array[1];break;
            }
            $product->setPseudo($names[$i]);
            $product->setNom($surnames[$i]);
            $product->setPrenom($names[$i]);
            $product->setEmail($names[$i].".".$surnames[$i] . "@mail.fr");
            $product->setPassword($this->passwordEncoder->encodePassword($product,"123456"));
            $product->setTelephone("01234567" . $i);
            $product->setSite($site);

            $manager->persist($product);


        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SiteFixtures::class
        ];
    }
}
