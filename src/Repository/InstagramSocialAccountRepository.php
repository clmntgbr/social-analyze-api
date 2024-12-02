<?php

namespace App\Repository;

use App\Entity\FacebookSocialAccount;
use App\Entity\InstagramSocialAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacebookSocialAccount>
 */
class InstagramSocialAccountRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstagramSocialAccount::class);
    }
}
