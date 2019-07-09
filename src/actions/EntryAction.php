<?php

namespace yozh\bitrix24\actions;

use yii\base\Action;
use yozh\bitrix24\models\Credentials;

/**
 * Class InstallAction
 * @package yozh\bitrix24\actions
 */
class EntryAction extends Action
{
    /**
     * @return string
     */
    public function run(): string
    {
        return $this->controller->render('entry', [
        ]);
    }
}
