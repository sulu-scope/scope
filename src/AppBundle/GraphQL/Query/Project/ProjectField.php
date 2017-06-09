<?php

namespace AppBundle\GraphQL\Query\Project;

use AppBundle\Entity\Project;
use AppBundle\GraphQL\Type\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQLBundle\Field\AbstractContainerAwareField;

class ProjectField extends AbstractContainerAwareField
{
    public function build(FieldConfig $config)
    {
        $this->addArgument('id', new NonNullType(new IntType()));
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository(Project::class);

        $queryBuilder = $repository->createQueryBuilder('entity');

        foreach ($info->getFieldASTList() as $index => $field) {
            $fieldName = 'entity.' . $field->getName();
            if ($index === 0) {
                $queryBuilder->select($fieldName);
            } else {
                $queryBuilder->addSelect($fieldName);
            }
        }

        $queryBuilder->where('entity.id = ' . $args['id']);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function getType()
    {
        return new ProjectType();
    }

    public function get($id)
    {
        return $this->container->get($id);
    }
}
