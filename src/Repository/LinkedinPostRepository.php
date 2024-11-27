<?php

namespace App\Repository;

use App\Entity\LinkedinPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkedinPost>
 */
class LinkedinPostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkedinPost::class);
    }

    public function create(array $updatePayload): LinkedinPost
    {
        $entity = new LinkedinPost();
        $this->update($entity, $updatePayload);
        return $entity;
    }
}
