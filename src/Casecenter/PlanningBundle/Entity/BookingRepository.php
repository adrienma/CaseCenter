<?php

namespace Casecenter\PlanningBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BookingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingRepository extends EntityRepository
{
	public function getWithDatesByUser($user)
	{
		$qb = $this->createQueryBuilder('a');
		$qb->leftJoin('a.dates', 'd')->addSelect('d');
		$qb->where('a.user = :user')->setParameter('user', $user);
		$qb->orderBy('a.creation', 'DESC');

		return $qb->getQuery()->getResult();
	}
}
