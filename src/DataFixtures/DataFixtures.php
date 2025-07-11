<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Freelance;
use App\Entity\Mission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Random\RandomException;

class DataFixtures extends Fixture
{
    /**
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $listeDeMots = ['administratif.jpeg', 'design.jpeg', 'devWeb.jpeg', 'marketing.jpeg', 'montage.jpeg', 'redaction.jpeg'];
        $actions = ['Développer', 'Créer', 'Concevoir', 'Rédiger', 'Mettre en place', 'Optimiser'];
        $objets = ['site e-commerce', 'application mobile', 'logo professionnel', 'stratégie SEO', 'article de blog', 'dashboard analytique'];
        $categorie = ['site e-commerce', 'application mobile', 'logo professionnel', 'stratégie SEO', 'article de blog', 'dashboard analytique'];

        for ($i = 1; $i <= 20; $i++) {
            $motAleatoire = $listeDeMots[array_rand($listeDeMots)];

            //clients
            $client = new Client();
            $client->setNom($faker->firstName());
            $client->setEmail($faker->email());
            $client->setRole('ROLE_CLIENT');
            $client->setPassword('test');
            $clients[] = $client;

            $manager->persist($client);

            //freelances
            $freelance = new Freelance();
            $freelance->setNom($faker->firstName());
            $freelance->setPrenom($faker->lastName());
            $freelance->setCompetances((array)$faker->jobTitle());
            $freelance->setEmail($faker->email());
            $freelance->setRole('ROLE_FREELANCE');
            $freelance->setPassword('test');

            $manager->persist($freelance);

            //missions
            foreach ($clients as $client) {
            $mission = new Mission();
            $mission->setTitre( $actions[array_rand($actions)] . ' ' . $objets[array_rand($objets)]);
            $mission->setDescription($faker->paragraph(10, true));
            $mission->setDuree($faker->numberBetween(2,5).' semaines');
            $mission->setClient($client);
            $mission->setDatePublication(new \DateTime("-$i days"));
            $mission->setNombreCandidatures(random_int(0, 20));
            $mission->setCategorie($categorie[array_rand($categorie)]);
            $mission->setImageName($motAleatoire);
            $mission->setIsImageUploaded(false); // ou true si upload Vich

            $manager->persist($mission);
            }
        }

        $manager->flush();
    }
}
