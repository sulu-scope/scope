<?php

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Youshido\GraphQL\Parser\Ast\Field;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Field[] $fields
     * @param QueryBuilder $queryBuilder
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function addFields(array $fields, QueryBuilder $queryBuilder, $alias = 'entity')
    {
        foreach ($fields as $index => $field) {
            $fieldName = $alias . '.' . $field->getName();
            if ($index === 0) {
                $queryBuilder->select($fieldName);

                continue;
            }

            $queryBuilder->addSelect($fieldName);
        }

        return $queryBuilder;
    }

    public function whereId($id, QueryBuilder $queryBuilder, $alias = 'entity')
    {
        return $queryBuilder->where($alias . '.id = ' . $id);
    }

    public function whereTitle($title, QueryBuilder $queryBuilder, $alias = 'entity')
    {
        $attribute = uniqid('title', true);

        return $queryBuilder
            ->where($alias . '.title LIKE :' . $attribute)
            ->setParameter($attribute, '%' . $title . '%');
    }
}
