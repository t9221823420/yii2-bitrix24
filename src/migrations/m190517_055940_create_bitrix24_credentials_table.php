<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bitrix24_credentials}}`.
 */
class m190517_055940_create_bitrix24_credentials_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable( '{{%bitrix24_credentials}}', [
            'id'            => $this->primaryKey(),
            'domain'        => $this->string(),
            'expires'       => $this->dateTime(),
            'access_token'  => $this->string(),
            'refresh_token' => $this->string(),
            'member_id'     => $this->string(),
            'changed'       => $this->dateTime(),
        ] );
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable( '{{%bitrix24_credentials}}' );
    }
}
