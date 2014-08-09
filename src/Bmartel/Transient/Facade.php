<?php
/**
 * Created by PhpStorm.
 * User: brand_000
 * Date: 09/08/14
 * Time: 2:18 AM
 */

namespace Bmartel\Transient;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Bmartel\Transient\Service';
    }


} 