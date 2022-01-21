<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Genre;
use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }


    public function findAllByNote(float $note, array $livres): array
    {
        if(sizeof($livres) == 0)
        {
            $entityManager = $this->getEntityManager();

        
            $query = $entityManager->createQuery(
                'SELECT l
                FROM App\Entity\Livre l
                WHERE l.note = :note
                '
            )->setParameter('note', $note);
        
        // returns an array of Product objects
        return $query->getResult();
        }

        $newLivres = array();
        foreach ($livres as  $livre)
        {
            if($livre->getNote() == $note)
            {
                 $newLivres[] = $livre;
            }
        }

        return $newLivres;
        

    }



    public function findAllByDatePub(\DateTimeInterface $date_de_parution, array $livres): array
    {
        if(sizeof($livres) == 0)
        {
            $entityManager = $this->getEntityManager();
        

            $query = $entityManager->createQuery(
            'SELECT l
            FROM App\Entity\Livre l
            WHERE l.date_de_parution = :date_de_parution
            '
            )->setParameter('date_de_parution', $date_de_parution);

            // returns an array of Product objects
            return $query->getResult();
        }

        $newLivres = array();
        foreach ($livres as $livre)
        {
            if($livre->getDateDeParution() == $date_de_parution)
            {
                 $newLivres[] = $livre;
            }
        }

        return $newLivres;
    }

    public function findAllByGenre(int $id, array $livres): array
    {
        if(sizeof($livres) == 0)
        {
          $entityManager = $this->getEntityManager();
          $repository = $entityManager->getRepository(Livre::class);

          $qry = $repository->createQueryBuilder('l')
            ->innerJoin('l.genres', 'genre')
            ->where('genre.id = :genre_id')
            ->setParameter('genre_id', $id)
            ->getQuery();

            return $qry->getResult();
        }

        $newLivres = array();
        foreach ($livres as $livre)
        {
            foreach ($livre->getGenres() as $genre)
            {
                if($genre->getId() == $id)
                {
                     $newLivres[] = $livre;
                     break;
                }
            }

            
        }

        return $newLivres;




    
    }

    public function findAllByAuteur(int $id, array $livres): array
    {
        if(sizeof($livres) == 0)
        {
        $entityManager = $this->getEntityManager();
        $repository = $entityManager->getRepository(Livre::class);

        
            $qry = $repository->createQueryBuilder('l')
         ->innerJoin('l.auteurs', 'auteur')
         ->where('auteur.id = :auteur_id')
         ->setParameter('auteur_id', $id)
         ->getQuery();
         return $qry->getResult();

        }


        $newLivres = array();
        foreach ($livres as $livre)
        {
            foreach ($livre->getAuteurs() as $auteur)
            {
                if($auteur->getId() == $id)
                {
                     $newLivres[] = $livre;
                     break;
                }
            }

            
        }

        return $newLivres;

    
    }



    public function findAllByDatePubRange(\DateTimeInterface $date_de_parution1, \DateTimeInterface $date_de_parution2): array
    {
       
            $entityManager = $this->getEntityManager();
        

            $query = $entityManager->createQuery(
            'SELECT l
            FROM App\Entity\Livre l
            WHERE l.date_de_parution BETWEEN :date_de_parution1 AND :date_de_parution2
            '
            )->setParameter('date_de_parution1', $date_de_parution1)->setParameter('date_de_parution2', $date_de_parution2);

            // returns an array of Product objects
            return $query->getResult();
        

        
    }




    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
