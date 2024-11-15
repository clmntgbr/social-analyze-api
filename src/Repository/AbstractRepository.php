<?php

namespace App\Repository;

use App\Entity\FacebookSocialAccount;
use App\Entity\SocialAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, self::class);
    }

    public function delete(SocialAccount $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    private function findOneByCriteria(array $criteria): ?self
    {
        $queryBuilder = $this->createQueryBuilder('p');

        foreach ($criteria as $key => $value) {
            $queryBuilder->andWhere("p.$key = :$key")
                ->setParameter($key, $value);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}