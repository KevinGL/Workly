<?php

namespace App\Repository;

use App\Entity\Society;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Society>
 */
class SocietyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Society::class);
    }

    //    /**
    //     * @return Society[] Returns an array of Society objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Society
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findRelaunchesToday(): array
    {
        $tz = new \DateTimeZone('Europe/Paris');
        $start = (new \DateTimeImmutable('today', $tz))->setTime(0, 0, 0);
        $end = $start->modify('+1 day');

        return $this->createQueryBuilder('s')
            ->andWhere('s.toRelaunchAt >= :start')
            ->andWhere('s.toRelaunchAt < :end')
            ->andWhere("s.relaunchedAt IS NULL")
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }
}
