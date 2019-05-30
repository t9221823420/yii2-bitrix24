<?php

namespace yozh\bitrix24;

use yii\base\BootstrapInterface;
use yii\web\UrlRule;

class Bootstrap implements BootstrapInterface
{
    
    public function bootstrap($app)
    {
        
        $app->getUrlManager()->addRules([
            
            // remove module/default/action
            [
                'class'   => UrlRule::class,
                'pattern' => 'bitrix24/install',
                'route'   => 'bitrix24/default/install',
            ],
            [
                'class'   => UrlRule::class,
                'pattern' => 'bitrix24/entry',
                'route'   => 'bitrix24/default/entry',
            ],
        
        ], false)
        ;
    }
}