<?php

namespace yozh\bitrix24\controllers;

use yii\base\Action;
use yii\web\Controller;
use yozh\bitrix24\actions\EntryAction;
use yozh\bitrix24\actions\InstallAction;

/**
 * Class DefaultController
 * @package yozh\bitrix24\controllers
 */
class DefaultController extends Controller
{
    public $layout = '@yozh/bitrix24/views/default/layout.php';
    
    /**
     * @return array
     */
    public function actions()
    {
        return [
            
            'install' => [
                'class' => InstallAction::class,
            ],
            
            'entry' => [
                'class' => EntryAction::class,
            ],
        
        ];
    }
    
    /**
     * @param Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id == 'install') {
            $this->enableCsrfValidation = false;
        }
        
        return parent::beforeAction($action);
    }
    
}
