<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class SerieRepository extends ServiceEntityRepository
{

    const SERIE_LIMIT = 50;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function save(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity); //Préparation de la requête insert ou update, je peux en faire autant que je veux

        //la différence entre insert et update est la présence d'un id dans l'objet $entity
        if ($flush) {
            $this->getEntityManager()->flush(); //Exécution de la requête
        }
    }

    public function remove(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity); //Préparation de la requête delete

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBestSeries(int $page){

        //Récupération des séries les mieux notées (>8) et les plus populaires (>100), ordonnées par popularité
        //Ecriture en DQL

/*        $dql = "SELECT s FROM App\Entity\Serie AS s WHERE s.vote > 8 AND s.popularity > 100 ORDER BY s.popularity DESC";

        $query = $this->getEntityManager()->createQuery($dql); //Transformation en objet de requête

        //On ne récupère que les 50 premiers au maximum
        $query->setMaxResults(50);

        */

        //Ecriture en QueryBuilder

        //Pagination :
        //page 1 -> 0 à 49
        //page 2 -> 50 à 99

        $offset = ($page - 1) * self::SERIE_LIMIT;

        $qb = $this->createQueryBuilder('s');
        $qb->addOrderBy('s.popularity', 'DESC');
      /*  $qb->andWhere('s.vote>8');
        $qb->andWhere('s.popularity>100');*/
        $qb->setMaxResults(self::SERIE_LIMIT);
        $qb->setFirstResult($offset);

        $query = $qb->getQuery(); //Transformation en objet de requête

        return $query->getResult();
    }


//    /**
//     * @return Serie[] Returns an array of Serie objects
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

//    public function findOneBySomeField($value): ?Serie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
