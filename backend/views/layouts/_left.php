<?php

/* @var $this \yii\web\View */

$menuItems = [
    ['label' => "Bosh sahifa", 'url' => ['/site/index'], 'icon' => 'home',],
    ['label' => "Buyurtma yaratish", 'url' => ['/orders/create'], 'icon' => 'cart-plus', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar", "Operator", "Diller"])],
//    ['label' => "Shona Kredit yaratish", 'url' => ['/orders/create-credit'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar", "Operator", "Diller"])],
    ['label' => "Sotuv", 'icon' => 'list-alt', "items" => [
        ['label' => "Buyurtmalar", 'url' => ['/orders'], 'icon' => 'clipboard-list',],
    ]],
    ['label' => "Ombor", 'icon' => 'download', "items" => [
//        ['label' => "Import", 'url' => ['/product-imports'], 'icon' => 'list', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
        ['label' => "Mahsulotlar", 'url' => ['/products'], 'icon' => 'store', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar", "Operator", "Diller"])],
        ['label' => "Hamkor do'konlar", 'url' => ['/partner-shops'], 'icon' => 'store-alt', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ]],
    ['label' => "Mijozlar", 'url' => ['/clients'], 'icon' => 'users', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
//    ['label' => "Maosh va bonus", 'url' => ['/salary'], 'icon' => 'list',],
    ['label' => "Hodimlar", 'icon' => 'user-alt', "items" => [
        ['label' => "Yangi yaratish", 'url' => ['/usermanager/user/create'], 'icon' => 'plus',],
        ['label' => "Ro'yhat", 'url' => ['/usermanager/user/index'], 'icon' => 'list',],
    ], "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ['label' => "To'lov usullari", 'url' => ['/payment-types'], 'icon' => 'dollar-sign', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ['label' => "Yetkazish usullari", 'url' => ['/delivery-types'], 'icon' => 'truck', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ['label' => "Mijoz oqim turlari", 'url' => ['/network-types'], 'icon' => 'hashtag', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Rahbar"])],
    ['label' => "Kurslar", 'url' => ['/currency/index'], 'icon' => 'hand-holding-usd', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Administrator", "Rahbar"])],
    ['label' => "Oylik maosh", 'url' => ['/staff/salary'], 'icon' => 'money-bill-wave', "visible" => !Yii::$app->user->identity->checkRoles(["Administrator", "Rahbar"])],
    ['label' => "Oylik maosh", 'url' => ['/staff/total-salary'], 'icon' => 'money-bill-wave', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Administrator", "Rahbar"])],
    ['label' => "Qarzdorlik", 'url' => ['/debt/index'], 'icon' => 'money-check-alt', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Administrator", "Rahbar"])],
    ['label' => "Harajatlar", 'icon' => 'money-check', "visible" => Yii::$app->user->identity->checkRoles(["admin", "Administrator", "Rahbar"]), "items" => [
        ['label' => "Ro'yhat", 'url' => ['/expenses/index'], 'icon' => 'list',],
        ['label' => "Harajat turlari", 'url' => ['/expense-types/index'], 'icon' => 'list',],
    ]],
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