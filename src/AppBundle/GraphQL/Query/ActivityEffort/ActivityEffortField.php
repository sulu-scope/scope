<?php

namespace AppBundle\GraphQL\Query\ActivityEffort;

use AppBundle\Entity\ActivityEffort;
use AppBundle\GraphQL\Type\ActivityEffortType;
use Doctrine\ORM\EntityManagerInterface;
use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQLBundle\Field\AbstractContainerAwareField;

class ActivityEffortField extends AbstractContainerAwareField
{
    /**
     * @var bool
     */
    private $hasId;

    /**
     * @param bool $hasId
     */
    public function __construct($hasId = true)
    {
        $this->hasId = $hasId;

        parent::__construct();
    }

    public function build(FieldConfig $config)
    {
        if ($this->hasId) {
            $this->addArgument('id', new NonNullType(new IntType()));
        }
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository(ActivityEffort::class);

        return $repository->get($value, $args, $info);
    }

    public function getType()
    {
        return new ActivityEffortType();
    }

    public function get($id)
    {
        return $this->container->get($id);
    }
}
