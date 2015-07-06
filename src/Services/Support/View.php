<?php namespace Services\Support;

use Services\Facade\AbstractFacade;

class View extends AbstractFacade {

    public static function getFacadeAccessor(){
        return 'view';
    }
}
