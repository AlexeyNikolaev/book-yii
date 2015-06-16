<?php
namespace app\models;

class Book extends \yii\db\ActiveRecord
{
    public $image;

    public function __construct()
    {
        parent::__construct();
        $this->date_create = (new \DateTime())->format('Y-m-d');
        $this->date_update = (new \DateTime())->format('Y-m-d');
    }

    public static function tableName()
    {
        return 'book';
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    public function authorName()
    {
        return $this->author->first_name . ' ' . $this->author->last_name;
    }

    public function rules()
    {
        return [
            [['name', 'author_id', 'date'], 'required'],
            [['image'], 'safe'],
            [['image'], 'file', 'extensions' => 'jpg, png']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'author_id' => 'Author',
            'preview' => 'Preview',
            'date' => 'Date'
        ];
    }
}
