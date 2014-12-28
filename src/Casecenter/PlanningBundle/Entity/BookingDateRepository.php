<?php

namespace Casecenter\PlanningBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BookingDateRepository
 */
class BookingDateRepository extends EntityRepository
{
	public function getCompleteFootball2014()
	{
		$qb = $this->createQueryBuilder('a');
		$qb->leftJoin('a.dates', 'd')->addSelect('d');
		$qb->where('a.user = :user')->setParameter('user', '1');
		$qb->orderBy('a.creation', 'DESC');

		return $qb->getQuery()->getResult();
	}
}
