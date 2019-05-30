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
        $this->createTable('{{%bitrix24_credentials}}', [
            'id'            => $this->primaryKey(),
            'member_id'     => $this->string(),
            'domain'        => $this->string(),
            'access_token'  => $this->string(),
            'refresh_token' => $this->string(),
            'changed'       => $this->dateTime(),
            'expires'       => $this->dateTime(),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bitrix24_credentials}}');
    }
}
