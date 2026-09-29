<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
private const string PLAIN_PASSWORD = 'password';
    public function __construct
    (
        private readonly UserPasswordHasherInterface $passwordHash,
    )
    {}

    public function load(ObjectManager $manager): void
    {
        #region users
        $aliceUser = new User();
        $aliceUser
            ->setEmail('alice@example.fr')
            ->setCreatedAt(new \DateTimeImmutable());
        $password = $this->passwordHash->hashPassword($aliceUser, self::PLAIN_PASSWORD);
        $aliceUser->setPassword($password);

        $bobUser = new User();
        $bobUser
            ->setEmail('bob@example.fr')
            ->setCreatedAt(new \DateTimeImmutable());
        $password = $this->passwordHash->hashPassword($bobUser, self::PLAIN_PASSWORD);
        $bobUser->setPassword($password);

        $camilleUser = new User();
        $camilleUser
            ->setEmail('camille.aubert@example.fr')
            ->setFirstName('Camille')
            ->setLastName('Aubert')
            ->setCreatedAt(new \DateTimeImmutable('2026-02-04'));
        $password = $this->passwordHash->hashPassword($camilleUser, self::PLAIN_PASSWORD);
        $camilleUser->setPassword($password);

        $manager->persist($aliceUser);
        $manager->persist($bobUser);
        $manager->persist($camilleUser);
        #endregion

        #region cities
        $cities = [
            'Paris',
            'Lyon',
            'Marseille',
            'Bordeaux',
            'Lille',
            'Strasbourg',
            'Toulouse',
            'Nantes',
            'Dijon',
            'Brest'
        ];

        foreach ($cities as $cityName)
        {
            $city = new City();
            $city
                ->setName($cityName)
                ->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($city);
        }
        #endregion

        $manager->flush();
    }
}
