<?php

namespace AppBundle\GraphQL\Mutation\Activity;

use AppBundle\Entity\Activity;
use AppBundle\GraphQL\Query\Activity\ActivityQueryBuilderTrait;
use AppBundle\GraphQL\Type\ActivityType;
use Doctrine\ORM\EntityManagerInterface;
use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQLBundle\Field\AbstractContainerAwareField;

class UpdateActivityField extends AbstractContainerAwareField
{
    use ActivityMapperTrait;
    use ActivityQueryBuilderTrait;

    public function build(FieldConfig $config)
    {
        $config->addArguments(
            [
                'id' => new NonNullType(new IntType()),
                'title' => new StringType(),
                'description' => new StringType(),
            ]
        );
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $activity = $entityManager->find(Activity::class, $args['id']);
        $this->mapActivity($args, $activity);
        $entityManager->flush();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository(Activity::class);
        $queryBuilder = $repository->createQueryBuilder('entity');

        $queryBuilder->where('entity.id = :id')->setParameter('id', $activity->getId());
        $this->addActivityFields($info->getFieldASTList(), $queryBuilder);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function getType()
    {
        return new ActivityType();
    }

    public function getName()
    {
        return 'activityUpdate';
    }

    public function get($id)
    {
        return $this->container->get($id);
    }
}
