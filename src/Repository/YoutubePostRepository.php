<?php

namespace App\Repository;

use App\Entity\FacebookPost;
use App\Entity\YoutubePost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacebookPost>
 */
class YoutubePostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YoutubePost::class);
    }

    public function create(array $updatePayload): YoutubePost
    {
        $entity = new YoutubePost();
        $this->update($entity, $updatePayload);
        return $entity;
    }
}
