<?php

namespace App\Repository;

use App\Entity\FacebookSocialAccount;
use App\Entity\YoutubeSocialAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacebookSocialAccount>
 */
class YoutubeSocialAccountRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YoutubeSocialAccount::class);
    }
}
