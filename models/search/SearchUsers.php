<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\models\User;

/**
 * Class SearchUsers
 *
 * @property array $groupItems
 * @property array $sortItems
 */
class SearchUsers extends Model
{
    /**
     * @var string searching username.
     */
    public $username;
    /**
     * @var integer searching group.
     */
    public $group_id;
    /**
     * @var string sort by username, registred date or post count.
     */
    public $sort_by;
    /**
     * @var string sort asc or desc.
     */
    public $sort_dir;

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],

            ['group_id', 'default', 'value' => -1],
            ['group_id', 'number', 'integerOnly' => true],

            ['sort_by', 'default', 'value' => 'username'],
            ['sort_by', 'trim'],

            ['sort_dir', 'default', 'value' => 'ASC'],
            ['sort_dir', 'trim'],
        ];
    }

    /**
     * Filters for userlist page.
     * @param $params array
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // create ActiveQuery
        $query = User::find()
            ->select(['id', 'username', 'number_posts', 'created_at']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->pagination = new Pagination([
            'forcePageParam' => false,
            'pageSizeLimit' => false,
            'defaultPageSize' => 50,
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->addOrderBy([
                'created_at' => SORT_ASC,
            ]);

            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username]);

        $colomn = 'created_at';
        if (strcasecmp($this->sort_by, 'username') == 0) {
            $colomn = 'username';
        } elseif (strcasecmp($this->sort_by, 'number_posts') == 0) {
            $colomn = 'number_posts';
        }

        if (strcasecmp($this->sort_dir, 'ASC') == 0) {
            $query->addOrderBy([$colomn => SORT_ASC]);
        } elseif (strcasecmp($this->sort_dir, 'DESC') == 0) {
            $query->addOrderBy([$colomn => SORT_DESC]);
        }

        return $dataProvider;
    }

    /**
     * Prepare data for `Sort by` dropdown list on userlist page.
     * @return array
     */
    public function getSortItems()
    {
        $items = [
            'registered' => Yii::t('app/userlist', 'By registered sort item'),
            'username' => Yii::t('app/userlist', 'Username sort item'),
            'number_posts' => Yii::t('app/userlist', 'By number of posts sort item'),
        ];

        return $items;
    }
}