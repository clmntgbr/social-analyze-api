<?php

namespace App\Repository;

use App\Entity\SocialAccount;
use App\Entity\TwitterSocialAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TwitterSocialAccount>
 */
class TwitterSocialAccountRepository extends AbstractRepository
{
}
