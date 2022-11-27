<?php

$this->title = Yii::t('app', 'Oylik');
$this->params['breadcrumbs'][] = $this->title;

$start = date("Y-1-1 00:00:00");
$end = date("Y-12-31 23:59:59");

use common\services\SalaryService;

?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="/admin/149071.png"
                                 alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?= Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name ?></h3>
                        <p class="text-muted text-center">Lavozim</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>

                </div>


            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Oyliklar - <?= date("Y") ?></h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Oy</th>
                                <th>Bonus</th>
                                <th>Jarima</th>
                                <th>Oylik maosh</th>
                                <th>Jami</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {

                                ?>

                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= t(date("F", strtotime(date("Y-{$i}-1")))) ?></td>
                                    <td><?= Yii::$app->formatter->asSum(500000) ?></td>
                                    <td><?= Yii::$app->formatter->asSum(120000) ?></td>
                                    <td><?= Yii::$app->formatter->asSum(SalaryService::getOperatorMonthlyOrderSalary(strtotime(date("Y-{$i}-1")), strtotime(date("Y-{$i}-t")))) ?></td>
                                    <td class="text-success"><b><?= Yii::$app->formatter->asSum(1880000) ?></b></td>
                                </tr>
                                <?php
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>