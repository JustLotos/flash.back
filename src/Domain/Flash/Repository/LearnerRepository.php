<?php

declare(strict_types=1);

namespace App\Domain\Flash\Repository;

use App\Domain\Flash\Entity\Learner\Learner;
use App\Domain\Flash\Entity\Learner\Types\Id;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class LearnerRepository extends ServiceEntityRepository
{
    /** @var EntityManager */
    private $manager;
    /** @var EntityRepository */
    private $repository;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Learner::class);
        $this->manager = $em;
        $this->repository = $em->getRepository(Learner::class);
    }

    public function getById(Id $id)
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function add(Learner $learner)
    {
        $this->manager->persist($learner);
    }
}
