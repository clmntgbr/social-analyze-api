<?php

namespace App\Repository;

use App\Entity\FacebookSocialAccount;
use App\Entity\SocialAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacebookSocialAccount>
 */
class FacebookSocialAccountRepository extends AbstractRepository
{
}
