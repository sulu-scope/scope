<?php

namespace AppBundle\Repository;

/**
 * CompanyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompanyRepository extends AbstractEntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'company';
    }
}
