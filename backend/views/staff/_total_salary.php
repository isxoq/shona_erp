<?php

$this->title = Yii::t('app', 'Oylik');
$this->params['breadcrumbs'][] = $this->title;

$start = date("Y-11-1 00:00:00");
$end = date("Y-12-31 23:59:59");

$staffs = \common\models\User::find()->all();

use common\services\SalaryService;

?>

<section class="content">
    <div class="container-fluid">
        <?php for ($i = 12; $i >= 1; $i--): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= t(date("F-Y", strtotime(date("Y-{$i}-1")))) ?></h3>
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

                                    $bonus = SalaryService::getStaffMonthlyOrderSalesBonus(strtotime(date("Y-{$i}-1")), strtotime(date("Y-{$i}-t")), $staff->id);
                                    $fine = SalaryService::getStaffMonthlyOrderSalesFine(strtotime(date("Y-{$i}-1")), strtotime(date("Y-{$i}-t")), $staff->id);
                                    $salary = SalaryService::getStaffMonthlyOrderSalary(strtotime(date("Y-{$i}-1")), strtotime(date("Y-{$i}-t")), $staff->id);

                                    $totalsalary = $bonus + $salary - $fine;
                                    ?>

                                    <tr>
                                        <td><?= $index++ ?></td>
                                        <td><?= $staff->first_name . " " . $staff->last_name ?></td>
                                        <td><?= Yii::$app->formatter->asSum($salary) ?></td>
                                        <td><?= Yii::$app->formatter->asSum($bonus) ?></td>
                                        <td class="<?= $fine > 0 ? "text-danger" : "" ?>"><?= Yii::$app->formatter->asSum($fine) ?></td>
                                        <td class="text-success"><b><?= Yii::$app->formatter->asSum($totalsalary) ?></b>
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
</section>