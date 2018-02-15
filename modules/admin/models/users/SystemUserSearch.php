<?php

namespace app\modules\admin\models\users;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\users\SystemUsersRecord;

/**
 * SystemUserSearch represents the model behind the search form about `app\modules\admin\models\user\SystemUserRecord`.
 */
class SystemUserSearch extends SystemUsersRecord
{
    public $global;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'global', 'password_hash', 'password_reset_token', 'email'], 'safe'],
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
        $query = SystemUsersRecord::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->global])
            ->orFilterWhere(['like', 'email', $this->global]);

        return $dataProvider;
    }
}
