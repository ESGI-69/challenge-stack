<?php

namespace App\Repository;

use App\Entity\MediasList;
use App\Entity\Arist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediasList>
 *
 * @method MediasList|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediasList|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediasList[]    findAll()
 * @method MediasList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediasListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediasList::class);
    }

    public function save(MediasList $entity, bool $flush = false): void
    {

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MediasList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function GetMedias(MediasList $artist): array
    {

        $qb = $this->createQueryBuilder('mediasList')
        ->andWhere('mediasList.id = :id')
        ->setParameter('id', $artist->getId())
        ->innerjoin('mediasList.medias', 'mediaMediasList')
        ->addSelect('mediaMediasList')
        ->groupBy('mediasList.id','mediaMediasList.id')
        ->getQuery()
        ->getResult();

        $result = [];
        
        $result = $qb[0]->getMedias()->toArray();

        return $result;
    }
    // public function mediaByArtist($artistId): array
    // {
    //     $qb = $this->createQueryBuilder('m');
    //     $qb->join('m.artists', 'ma')
    //         ->where('ma.id = :artistId')
    //         ->setParameter('artistId', $artistId )
    //         ->getQuery()
    //         ->getResult();
    //     return $qb->getQuery()->getResult();
    // }

    public function mediasListsByArtist(int $artistId): array
    {
        $qb = $this->createQueryBuilder('ml');
        $qb->join('ml.artists', 'ma')
            ->where('ma.id = :artistId')
            ->setParameter('artistId', $artistId )
            ->getQuery()
            ->getResult();
        return $qb->getQuery()->getResult();
    }


    // public function getTotalDuration(MediasList $ml): int
    // {
    //     $qb = $this->createQueryBuilder('mediasList')
    //     // ->select('SUM(mediasMediasList.duree) as total', 'mediasList', 'mediaMediasList')
    //     ->andWhere('mediasList.id = :id')
    //     ->setParameter('id', $ml->getId())
    //     ->innerjoin('mediasList.medias', 'mediaMediasList')
    //     ->addSelect('mediaMediasList')
    //     ->groupBy('mediasList.id','mediaMediasList.id')
    //     ->getQuery()
    //     ->getResult();

    //     dd($qb);
    // }

//    /**
//     * @return MediasList[] Returns an array of MediasList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MediasList
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
