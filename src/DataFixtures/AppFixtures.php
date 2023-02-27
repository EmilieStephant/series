<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void //ObjectManager implémente EntityManagerInterface
    {
        $faker = Factory::create('fr_FR');
        $this->addSeries($manager, $faker);
    }

    public function addSeries(ObjectManager $manager, Generator $generator){
        for ($i=0; $i<50; $i++){

            $serie = new Serie();
            $serie->setName(implode(" ", $generator->words(3)));
            $serie->setVote($generator->numberBetween(0,10));
            $serie->setStatus($generator->randomElement(["ended", "returning", "canceled"]));
            $serie->setPoster("poster.png");
            $serie->setTmdbId(123);
            $serie->setPopularity(250);
            $serie->setFirstAirDate($generator->dateTimeBetween("-6 month"));
            $serie->setLastAirDate($generator->dateTimeBetween($serie->getFirstAirDate()));
            $serie->setGenres($generator->randomElement(["Western", "Comedy", "Drama"]));
            $serie->setBackdrop("backdrop.png");

            $manager->persist($serie);
        }

        $manager->flush();
    }
}
