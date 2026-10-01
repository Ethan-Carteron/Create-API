<?php
namespace App\Service\Utils;

use App\Entity\Impl\AbstractEntity;
use Symfony\Bundle\SecurityBundle\Security;

class AuditService
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    /**
     * Stamps an entity as created now, by the current user when there is one.
     */
    public function stampCreation(AbstractEntity $entity): void
    {
        $entity->setCreatedAt(new \DateTimeImmutable());
        $entity->setCreatedBy($this->security->getUser());
    }

    /**
     * Stamps an entity as updated now, by the current user when there is one.
     */
    public function stampUpdate(AbstractEntity $entity): void
    {
        // ...
    }

    /**
     * Marks an entity as deleted now, by the current user when there is one.
     */
    public function markDeleted(AbstractEntity $entity): void
    {
        // ...
    }
}
