<?php

namespace yozh\bitrix24\actions;

use yii\base\Action;
use yozh\bitrix24\models\Credentials;

/**
 * Class InstallAction
 * @package yozh\bitrix24\actions
 */
class InstallAction extends Action
{
    /**
     * @return string
     */
    public function run(): string
    {
        $request    = \Yii::$app->getRequest();
        $errorsList = [];
        
        try {
            
            if (!$Credentials = Credentials::findOne(['member_id' => $request->get('member_id')])) {
                $Credentials = new Credentials();
            }
            
            //setting changed date
            $changed = new \DateTime('now');
            
            //setting expires date
            $expires  = clone $changed;
            $duration = (int)$request->post('AUTH_EXPIRES');
            $expires->add(new \DateInterval('PT' . $duration . 'S'));
            
            $Credentials->setAttributes([
                'domain'        => $request->get('DOMAIN'),
                'access_token'  => $request->post('AUTH_ID'),
                'refresh_token' => $request->post('REFRESH_ID'),
                'member_id'     => $request->post('member_id'),
                'changed'       => $changed->format('Y-m-d H:i:s'),
                'expires'       => $expires->format('Y-m-d H:i:s'),
            ]);
            
            if (!$Credentials->save()) {
                $errorsList = $Credentials->getErrors();
            };
            
        } catch (\Exception $exception) {
            $errorsList[] = $exception->getMessage();
        }
        
        return $this->controller->render('install', [
            'errorsList' => $errorsList,
        ]);
    }
}
