<?php
namespace app\models;

use yii\db\Connection;
use yii\db\Command;

class Author extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'author';
    }

    public function getOrders()
    {
        return $this->hasMany(Book::className(), ['author_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return array
     */
    public static function findAllAsArray()
    {
        $authorArray = [];
        $authors = self::find()->all();
        foreach ($authors as $author) {
            $authorArray[$author->id] = $author->getFullName();
        }

        return $authorArray;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullName();
    }
}
