<?php

use yii\db\Schema;
use yii\db\Migration;

class m150609_083400_initial extends Migration
{
    public function up()
    {
        try {
            $this->createTable('author', [
                'id' => 'pk',
                'first_name' => 'string NOT NULL',
                'last_name' => 'string NOT NULL',
            ]);
            $this->createTable('book', [
                'id' => 'pk',
                'name' => 'string NOT NULL',
                'date_create' => 'datetime NOT NULL',
                'date_update' => 'datetime NOT NULL',
                'preview' => 'string',
                'date' => 'datetime NOT NULL',
                'author_id' => 'integer NOT NULL'
            ]);
            $this->addForeignKey('fk_book_author', 'book', 'author_id', 'author', 'id');

            $this->insert('author', [
                'first_name' => 'Alexey',
                'last_name' => 'Tolstoy',
            ]);
            $this->insert('author', [
                'first_name' => 'Alexandr',
                'last_name' => 'Pushkin',
            ]);
            $this->insert('book', [
                'name' => 'Stories',
                'date_create' => 'now()',
                'date_update' => 'now()',
                'date' => '1988-01-01',
                'author_id' => 1
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_book_author', 'book');
        $this->dropTable('book');
        $this->dropTable('author');
    }
    

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }

}
