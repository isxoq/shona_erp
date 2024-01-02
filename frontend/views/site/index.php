<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 15.07.2021, 10:46
 */

/* @var $this soft\web\View */

use yii\helpers\Html;

$this->title = Yii::$app->params['appName'];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="text-center"><?= Html::encode(Yii::$app->params['appName']) ?></h1>
<br><br><br>
<div class="row justify-content-center">
    <div class="col-md-12 text-center">
        <h1>Hush kelibsiz!</h1>
        <a href="/admin" class="btn btn-primary">BOSHQARUV PANELI</a>
    </div>
</div>
