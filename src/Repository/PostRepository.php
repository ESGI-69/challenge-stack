<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getFollowedArtistPosts($user, $count = 10)
    {
        $result = $this->createQueryBuilder('post')
        ->leftJoin('post.id_artist', 'postArtist')
        ->leftJoin('post.comments', 'postComments')
        ->leftJoin('postComments.id_user', 'postCommentsUser')
        ->leftJoin('post.userslike', 'postLikes')
        ->leftJoin('postArtist.followed', 'postArtistFollowed')
        ->where('post.validated_at IS NOT NULL')
        ->addSelect('postArtist')
        ->addSelect('postComments')
        ->addSelect('postLikes')
        ->addSelect('postCommentsUser')
        ->addSelect('postArtistFollowed')
        ->groupBy('post.id', 'postArtist.id', 'postComments.id', 'postLikes.id', 'postCommentsUser.id', 'postArtistFollowed.id')
        ->orderBy('post.created_at', 'DESC')
        ->setMaxResults($count)
        ->getQuery()
        ->getResult();

        return $result;
    }

    public function getLastCreate(int $count = 5): array
    {
        $dirtyResult = $this->createQueryBuilder('post')
        // ->select('COUNT(pc.id) as comments', 'a', 'pc')
        ->leftJoin('post.id_artist', 'postArtist')
        ->leftJoin('post.comments', 'postComments')
        ->leftJoin('postComments.id_user', 'postCommentsUser')
        ->leftJoin('post.userslike', 'postLikes')
        ->where('post.validated_at IS NOT NULL')
        ->addSelect('postArtist')
        ->addSelect('postComments')
        ->addSelect('postLikes')
        ->addSelect('postCommentsUser')
        ->groupBy('post.id', 'postArtist.id', 'postComments.id', 'postLikes.id', 'postCommentsUser.id')
        ->addSelect('COUNT(postComments.id) as commentCount')
        ->addSelect('COUNT(postLikes.id) as likeCount')
        ->orderBy('post.created_at', 'DESC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();

        
        $result = [];
        foreach ($dirtyResult as $row) {
            $row[0]->likeCount = $row['likeCount'];
            $row[0]->commentCount = $row['commentCount'];
            $result[] = $row[0];
        }
        return $result;
    }

    public function getUnvalidatedPostIdsFromArtist(int $artistId): array
    {
        $dirtyResult = $this->createQueryBuilder('post')
            ->select('post.id')
            ->andWhere('post.id_artist = :artistId')
            ->andWhere('post.validated_at IS NULL')
            ->setParameter('artistId', $artistId)
            ->orderBy('post.id', 'DESC')
            ->getQuery()
            ->getResult();
            
        $result = [];
        foreach ($dirtyResult as $row) {
            $result[] = $row['id'];
        }

        return $result;
    }

    public function getPostsFromArtist(int $artistId): array
    {
      // select * where id_artist = $artistId
      return $this->createQueryBuilder('post')
        ->andWhere('post.id_artist = :artistId')
        ->setParameter('artistId', $artistId)
        ->orderBy('post.id', 'ASC')
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * Retrive all post from a artist
    //  */
    // public function getPostsFromArtist(int $artistId): array
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.artist = :artistId')
    //         ->setParameter('id_user', $artistId)
    //         ->orderBy('p.id', 'DESC')
    //         ->getQuery()
    //         ->getResult();
    // }

//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
