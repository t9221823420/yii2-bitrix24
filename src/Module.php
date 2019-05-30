<?php

namespace yozh\bitrix24;

class Module extends \yii\base\Module
{
    
    const MODULE_ID = 'bitrix24';
    
    public $controllerNamespace = 'yozh\\' . self::MODULE_ID . '\controllers';
    
    /*
    public $app_scope;
    
    public $app_id;
    
    public $app_secret;
    */
}
