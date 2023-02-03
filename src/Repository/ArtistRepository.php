<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artist>
 *
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function save(Artist $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getLastCreate(int $count): array
    {
        $dirtyResult = $this->createQueryBuilder('a')
            ->select('a, COUNT(au.id) as followers, COUNT(ae.id) as events')
            ->leftJoin('a.followed', 'au')
            ->leftJoin('a.events', 'ae')
            ->groupBy('a.id')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($dirtyResult as $row) {
            $row[0]->followerCount = $row['followers'];
            $row[0]->eventCount = $row['events'];
            $result[] = $row[0];
        }
        return $result;
    }

    public function getTrending(int $count): array
    {
        $dirtyResult = $this->createQueryBuilder('a')
            ->select('a, COUNT(au.id) as followers, COUNT(ae.id) as events')
            ->leftJoin('a.followed', 'au')
            ->leftJoin('a.events', 'ae')
            ->groupBy('a.id')
            ->orderBy('followers', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($dirtyResult as $row) {
            $row[0]->followerCount = $row['followers'];
            $row[0]->eventCount = $row['events'];
            $result[] = $row[0];
        }
        return $result;
    }

    public function getFollowersCount(int $id): int
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(au.id) as followers')
            ->leftJoin('a.followed', 'au')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function remove(Artist $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Artist[] Returns an array of Artist objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Artist
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
