<?php

namespace App\Repository;

use App\Entity\TwitterPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TwitterPost>
 */
class TwitterPostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TwitterPost::class);
    }

    public function create(array $updatePayload): TwitterPost
    {
        $entity = new TwitterPost();
        $this->update($entity, $updatePayload);
        return $entity;
    }
}
