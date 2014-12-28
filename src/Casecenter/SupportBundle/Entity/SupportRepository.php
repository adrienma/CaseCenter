<?php

namespace Casecenter\SupportBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SupportRepository
 */
class SupportRepository extends EntityRepository
{
	public function getWithPages()
	{
		$qb = $this->createQueryBuilder('a');
		$qb->leftJoin('a.pages', 'p')->addSelect('p');
		$qb->orderBy('a.name', 'ASC');
		
		return $qb->getQuery()->getResult();
	}
}