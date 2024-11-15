<?php

namespace App\Repository;

use App\Entity\LinkedinSocialAccount;
use App\Entity\SocialAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkedinSocialAccount>
 */
class LinkedinSocialAccountRepository extends AbstractRepository
{
}
