<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\TextBundle\Doctrine\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Silvestra\Component\Text\Model\TextInterface;
use Silvestra\Component\Text\Model\Manager\TextManager as BaseTextManager;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class TextManager extends BaseTextManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param EntityManager     $em
     * @param string            $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository($class);
        $this->class      = $em->getClassMetadata($class)->name;
    }

    /**
     * {@inheritdoc}
     */
    public function findTextBySlugAndLocale($slug, $locale)
    {
        $qb = $this->repository->createQueryBuilder('text');

        $qb->innerJoin('text.translations', 'translation', Join::WITH, $qb->expr()->eq('translation.lang', ':locale'))
            ->setParameter('locale', $locale);

        $qb->andWhere($qb->expr()->eq('text.slug', ':slug'))
            ->setParameter('slug', $slug);

        $qb->select('text, translation');

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function add(TextInterface $text, $save = false)
    {
        $this->em->persist($text);

        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(TextInterface $text, $save = false)
    {
        $this->em->remove($text);

        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->em->clear($this->class);
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}
