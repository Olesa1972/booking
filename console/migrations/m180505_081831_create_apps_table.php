<?php

use yii\db\Migration;

/**
 * Handles the creation of table `apps`.
 */
class m180505_081831_create_apps_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('applications', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'phone' => $this->string(),
            'status' => $this->string(),
            'created_at' => $this->string(),
            'apartment_id' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('applications');
    }
}
