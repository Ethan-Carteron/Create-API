<?php

namespace App\Service;

use App\Dto\User\UserRegisterInput;
use App\Entity\User;
use App\Service\Utils\AuditService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly AuditService $auditService,
    ) {
    }

    public function register(UserRegisterInput $input): User
    {
        $user = new User();
        $user->setEmail($input->email);
        $user->setPassword($this->hasher->hashPassword($user, $input->password));
        $user->setFirstName($input->firstName);
        $user->setLastName($input->lastName);

        $this->auditService->stampCreation($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
