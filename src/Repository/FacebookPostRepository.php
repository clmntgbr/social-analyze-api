<?php

namespace App\Repository;

use App\Entity\FacebookPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacebookPost>
 */
class FacebookPostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacebookPost::class);
    }

    public function create(array $updatePayload): FacebookPost
    {
        $entity = new FacebookPost();
        $this->update($entity, $updatePayload);
        return $entity;
    }
}
