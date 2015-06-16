<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Book;

/**
 * BookSearch represents the model behind the search form about `app\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * @var \DateTime
     */
    public $date_from;

    /**
     * @var \DateTime
     */
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'name', 'date_from', 'date_to'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Book::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'author_id' => $this->author_id
        ]);

        $query->andFilterWhere(['>=', 'date', $this->date_from]);
        $query->andFilterWhere(['<=', 'date', $this->date_to]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        /*$query->where(['author_id' => $this->author_id]);
        $query->andWhere(['>=', 'date', $this->date_from]);
        $query->andWhere(['<=', 'date', $this->date_to]);
        $query->andWhere(['like', 'name', "$this->name"]);*/

        return $dataProvider;
    }
}
