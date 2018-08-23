<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\assets\CommonAsset;

CommonAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src='//at.alicdn.com/t/font_528644_s64g3a7fpd.js'></script>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap wrapper">
        <div class='navbarDocker'>
            <?php
                echo $this->render('top');
            ?>
        </div>
        <div class='sidebarDocker'>
            <?php
                echo $this->render('left');
            ?>
        </div>
        <div class='mainDocker'>
            <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
                <el-breadcrumb separator-class="el-icon-arrow-right">
                    <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                    <el-breadcrumb-item>活动管理</el-breadcrumb-item>
                    <el-breadcrumb-item>活动列表</el-breadcrumb-item>
                    <el-breadcrumb-item>活动详情</el-breadcrumb-item>
                </el-breadcrumb>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    var mainVm = new Vue({
        el: '.wrapper'
    })
</script>
<?php $this->endBody() ?>
<?php $this->endPage() ?>
