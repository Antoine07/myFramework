<?php namespace Services\Support;

use Services\Facade\AbstractFacade;

class App extends AbstractFacade {

    public static function getFacadeAccessor(){
        return 'container';
    }
}
