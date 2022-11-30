<?php

$this->title = Yii::t('app', 'Oylik');
$this->params['breadcrumbs'][] = $this->title;

$start = date("Y-11-1 00:00:00");
$end = date("Y-12-31 23:59:59");

$staffs = \common\models\User::find()->all();

use common\services\SalaryService;

?>

<section class="content">
    <?php for ($year = 2022; $year <= 2023; $year++): ?>
        <div class="container-fluid">
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <?php
                if ($i < 11 && $year == 2022) {
                    continue;
                }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?= t(date("F", strtotime(date("{$year}-{$i}-1")))) . "-" . $year ?></h3>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Hodim</th>
                                        <th>Oylik maosh</th>
                                        <th>Bonus</th>
                                        <th>Jarima</th>
                                        <th>Jami</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $index = 1; ?>

                                    <?php foreach ($staffs as $staff): ?>

                                        <?php
                                        if ($staff->checkRoles(["admin", "Rahbar"])) {
                                            continue;
                                        }

                                        $bonus = SalaryService::getStaffMonthlyOrderSalesBonus(strtotime(date("{$year}-{$i}-1")), strtotime(date("{$year}-{$i}-t")), $staff->id);
                                        $fine = SalaryService::getStaffMonthlyOrderSalesFine(strtotime(date("{$year}-{$i}-1")), strtotime(date("{$year}-{$i}-t")), $staff->id);
                                        $salary = SalaryService::getStaffMonthlyOrderSalary(strtotime(date("{$year}-{$i}-1")), strtotime(date("{$year}-{$i}-t")), $staff->id);
                                        $totalsalary = $bonus + $salary - $fine;
                                        ?>

                                        <tr>
                                            <td><?= $index++ ?></td>
                                            <td><?= $staff->first_name . " " . $staff->last_name ?></td>
                                            <td><?= Yii::$app->formatter->asSum($salary) ?></td>
                                            <td><?= Yii::$app->formatter->asSum($bonus) ?></td>
                                            <td class="<?= $fine > 0 ? "text-danger" : "" ?>"><?= Yii::$app->formatter->asSum($fine) ?></td>
                                            <td class="text-success">
                                                <b><?= Yii::$app->formatter->asSum($totalsalary) ?></b>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endfor ?>
        </div>
    <?php endfor ?>
</section>