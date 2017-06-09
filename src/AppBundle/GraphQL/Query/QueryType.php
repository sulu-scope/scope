<?php

namespace AppBundle\GraphQL\Query;

use AppBundle\GraphQL\Query\Activity\ActivitiesField;
use AppBundle\GraphQL\Query\Activity\ActivityField;
use AppBundle\GraphQL\Query\Package\PackageField;
use AppBundle\GraphQL\Query\Package\PackagesField;
use AppBundle\GraphQL\Query\Project\ProjectField;
use AppBundle\GraphQL\Query\Project\ProjectsField;
use Youshido\GraphQL\Type\Object\AbstractObjectType;

class QueryType extends AbstractObjectType
{
    public function build($config)
    {
        $config->addFields(
            [
                // projects
                new ProjectsField(),
                new ProjectField(),

                // packages
                new PackagesField(),
                new PackageField(),

                // activites
                new ActivityField(),
                new ActivitiesField(),
            ]
        );
    }
}
