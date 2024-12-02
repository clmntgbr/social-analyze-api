<?php

namespace App\Repository;

use App\Entity\FacebookPost;
use App\Entity\InstagramPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacebookPost>
 */
class InstagramPostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstagramPost::class);
    }

    public function create(array $updatePayload): InstagramPost
    {
        $entity = new InstagramPost();
        $this->update($entity, $updatePayload);
        return $entity;
    }
}
