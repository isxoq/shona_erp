<?php

/* @var $this \yii\web\View */

$menuItems = [
    ['label' => "Bosh sahifa", 'url' => ['/site/index'], 'icon' => 'home',],
    ['label' => "POS", 'url' => ['/orders/create'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar", "Operator", "Diller"])],
    ['label' => "Shona Kredit yaratish", 'url' => ['/orders/create-credit'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar", "Operator", "Diller"])],
    ['label' => "Sotuv", 'icon' => 'list', "items" => [
        ['label' => "Buyurtmalar", 'url' => ['/orders'], 'icon' => 'list',],
    ]],
    ['label' => "Import", 'icon' => 'list', "items" => [
        ['label' => "Import", 'url' => ['/product-imports'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
        ['label' => "Mahsulotlar", 'url' => ['/products'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar", "Operator", "Diller"])],
        ['label' => "Hamkor do'konlar", 'url' => ['/partner-shops'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ]],
    ['label' => "Mijozlar", 'url' => ['/clients'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
//    ['label' => "Maosh va bonus", 'url' => ['/salary'], 'icon' => 'list',],
    ['label' => "Hodimlar", 'icon' => 'list', "items" => [
        ['label' => "Yangi yaratish", 'url' => ['/usermanager/user/create'], 'icon' => 'list',],
        ['label' => "Ro'yhat", 'url' => ['/usermanager/user/index'], 'icon' => 'list',],
    ], "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ['label' => "To'lov usullari", 'url' => ['/payment-types'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ['label' => "Yetkazish usullari", 'url' => ['/delivery-types'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ['label' => "Mijoz oqim turlari", 'url' => ['/network-types'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ['label' => "Kurslar", 'url' => ['/currency/index'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Administrator", "Rahbar"])],
    ['label' => "Oylik maosh", 'url' => ['/staff/salary'], 'icon' => 'list', "visible" => !Yii::$app->user->identity->checkRoles(["Administrator", "Rahbar"])],
    ['label' => "Oylik maosh", 'url' => ['/staff/total-salary'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Administrator", "Rahbar"])],
    ['label' => "Qarzdorlik", 'url' => ['/debt/index'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Administrator", "Rahbar"])],
    ['label' => "Translations", 'url' => ['/translate-manager'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin"])],
    ['label' => "Gii", 'url' => ['/gii'], 'icon' => 'code,fas', 'visible' => YII_DEBUG],
    ['label' => "Clear cache", 'url' => ['/site/cache-flush'], 'icon' => 'broom,fas', 'visible' => YII_DEBUG],
];

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= to(['site/index']) ?>" class="brand-link">
        <img src="/template/adminlte3//img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->user->identity->username ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?=
            \soft\widget\adminlte3\Menu::widget([
                'items' => $menuItems,
            ])
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>