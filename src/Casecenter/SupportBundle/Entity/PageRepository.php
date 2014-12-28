<?php

namespace Casecenter\SupportBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 */
class PageRepository extends EntityRepository
{
	public function getWithSupport($slugSupport, $slug)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('a');
		$qb->from($this->_entityName, 'a');
		$qb->innerJoin('a.support', 'p', 'WITH', 'p.slug = :slugSupport')->setParameter('slugSupport', $slugSupport);
		$qb->addSelect('p');
		$qb->where('a.slug = :slug')->setParameter('slug', $slug);

		try {
			return $qb->getQuery()->getSingleResult();
		} catch (\Doctrine\Orm\NoResultException $e) {return null;}
	}

	public function getWithFormats($support)
	{
		$qb = $this->createQueryBuilder('a');
		$qb->leftJoin('a.formats', 'f')->addSelect('f');
		$qb->where('a.support = :id')->setParameter('id', $support->getId());
		$qb->orderBy('a.name', 'ASC');
		
		return $qb->getQuery()->getResult();
	}
}
