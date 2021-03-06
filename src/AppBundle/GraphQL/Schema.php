<?php

namespace AppBundle\GraphQL;

use AppBundle\GraphQL\Mutation\MutationType;
use AppBundle\GraphQL\Query\QueryType;
use Youshido\GraphQL\Config\Schema\SchemaConfig;
use Youshido\GraphQL\Schema\AbstractSchema;

class Schema extends AbstractSchema
{
    public function build(SchemaConfig $config)
    {
        $config->setQuery(new QueryType())->setMutation(new MutationType());
    }
}

