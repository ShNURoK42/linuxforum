<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use app\models\Group;
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
            ->select(['id', 'group_id', 'username', 'title', 'num_posts', 'registered'])
            ->with('group');

        // exclude guest row from userlist
        $query->where(['NOT IN', 'id', 1]);

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
                'registered' => SORT_ASC,
            ]);

            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username]);

        if ($this->group_id != -1) {
            $query->andFilterWhere(['group_id' => $this->group_id]);
        }

        $colomn = 'registered';
        if (strcasecmp($this->sort_by, 'username') == 0) {
            $colomn = 'username';
        } elseif (strcasecmp($this->sort_by, 'number_posts') == 0 && Yii::$app->config->get('o_show_post_count') == '1') {
            $colomn = 'num_posts';
        }

        if (strcasecmp($this->sort_dir, 'ASC') == 0) {
            $query->addOrderBy([$colomn => SORT_ASC]);
        } elseif (strcasecmp($this->sort_dir, 'DESC') == 0) {
            $query->addOrderBy([$colomn => SORT_DESC]);
        }

        return $dataProvider;
    }

    /**
     * Prepare data for `User group` dropdown list on userlist page.
     * @return array
     */
    public function getGroupItems()
    {
        $items =  Group::getDropDownItems();
        $items = ArrayHelper::merge(['-1' => Yii::t('app/userlist', 'All')], $items);

        return $items;
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
        ];

        if ((Yii::$app->config->get('o_show_post_count') == '1')) {
            $items['number_posts'] = Yii::t('app/userlist', 'By number of posts sort item');
        }

        return $items;
    }
}