<?php

declare(strict_types=1);

namespace App\Model\Core\Repository;

use App\Model\Core\Entity\Card\Card;
use App\Model\Core\Entity\Learner\Types\Id;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    /** @var EntityManager */
    private $manager;
    /** @var EntityRepository */
    private $repository;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Card::class);
        $this->manager = $em;
        $this->repository = $em->getRepository(Card::class);
    }

    public function fetchAll(Id $id)
    {
        $qb = $this->repository->createQueryBuilder('card')
            ->select('card')
            ->leftJoin('card.deck', 'deck')
            ->leftJoin('deck.learner', 'learner')
            ->andWhere('learner.id = :id')
            ->setParameter('id', $id)
            ->andWhere('card.deck = deck');
        return $qb->getQuery()->execute();
    }

    public function add(Card $card)
    {
        $this->manager->persist($card);
    }
    public function remove(Card $card)
    {
        $this->manager->remove($card);
    }
}
