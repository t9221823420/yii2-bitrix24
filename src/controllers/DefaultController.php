<?php
/**
 * Created by PhpStorm.
 * User: bw
 * Date: 17.05.2019
 * Time: 11:20
 */

namespace yozh\bitrix24\controllers;

use yii\web\Controller;
use yozh\bitrix24\actions\EntryAction;
use yozh\bitrix24\actions\InstallAction;

/**
 * Class DefaultController
 * @package yozh\bitrix24\controllers
 */
class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            
            'install' => [
                'class' => InstallAction::class,
            ],
            
            'entry'   => [
                'class' => EntryAction::class,
            ],
        
        ];
    }
    
}