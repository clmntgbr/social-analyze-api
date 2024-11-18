<?php

namespace App\Repository;

use App\Entity\Analysis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Analysis>
 */
class AnalysisRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Analysis::class);
    }

    public function updateOrCreate(array $searchPayload, array $updatePayload): Analysis
    {
        $account = $this->findOneByCriteria($searchPayload);
        if (!$account) {
            $account = new Analysis();
        }

        $this->update($account, $updatePayload);
        return $account;
    }
}
