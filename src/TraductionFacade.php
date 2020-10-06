<?php

namespace Boblarouche\Traduction;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Boblarouche\Traduction\Skeleton\SkeletonClass
 */
class TraductionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'traduction';
    }
}
