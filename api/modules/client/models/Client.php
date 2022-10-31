<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 29.07.2021, 11:29
 */

namespace api\modules\client\models;

use common\models\User;
use Yii;


class Client extends User
{

    public function fields()
    {
        return [
            'id',
            "auth_key",
            "first_name",
            "last_name",
            "father_name",
            "phone",
            "jshshir",
            "image" => function ($model) {
                return Yii::$app->request->hostInfo . $model->image;
            },
            "birth_date",
            "gender",
            "province",
            "region",
            "age",
        ];
    }


}
