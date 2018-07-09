<?php

namespace Busman\Utils\Traits;

use Busman\People\TeamScope as Scope;

/**
 * TeamScope Trait
 *
 * @package \Busman\Utils\Traits
 */
trait HasScope
{
    /*
     * Defines the tenancy scope
     */
    protected static function boot()
    {
        parent::boot();

        if (isset(self::$scope[0])) {
            $scope = new self::$scope[0];
        } else {
            $scope = new Scope;
        }

        static::addGlobalScope($scope);
    }
}
