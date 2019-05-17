<?php

namespace yozh\bitrix24\models;

use Yii;

/**
 * This is the model class for table "block".
 *
 * @property int $id
 * @property string $domain
 * @property string $expires
 * @property string $access_token
 * @property string $refresh_token
 * @property string $member_id
 * @property string $changed
 *
 * @property PageBlock[] $pageBlocks
 */
class Credentials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bitrix24_credentials}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain', 'expires', 'access_token', 'refresh_token', 'member_id', 'changed'], 'required'],
            [['domain', 'expires', 'access_token', 'refresh_token', 'member_id', 'changed'], 'string', 'max' => 255],
        ];
    }
    
}
