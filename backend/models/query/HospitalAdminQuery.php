<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\HospitalAdmin]].
 *
 * @see \backend\models\HospitalAdmin
 */
class HospitalAdminQuery extends \soft\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/



    /**
     * {@inheritdoc}
     * @return \backend\models\HospitalAdmin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\HospitalAdmin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
