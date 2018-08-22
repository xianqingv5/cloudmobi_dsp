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
    <script src='//at.alicdn.com/t/font_528644_01xn979qizkqehfr.js'></script>
<style>
.icon {
width: 1em; height: 1em;
vertical-align: -0.15em;
fill: currentColor;
overflow: hidden;
}
img{
width: 100%;
height: auto;
}
.h100{
height: 100%;
}
a{
text-decoration: none;
color: #606266 !important;
}
a:focus{
text-decoration: none;
}
.jc-btween{
justify-content: space-between;
}
.wrapper{
display: grid;
grid-auto-columns: 230px 1fr;
grid-auto-rows: 50px 1fr;
margin: 0 !important;
padding: 0 !important;
}
.breadcrumbDocker{
height: 50px;
padding-left: 38px;
border-top: 1px solid #e0e0e0;
border-bottom: 1px solid #e0e0e0;
}
.navbarDocker{
width: 100%;
height: 50px;
grid-column-start: 1;
grid-column-end: 3;
}
.signOut{
padding: 0 50px;
border-left: 1px solid #ccc;
}
.userIcon{
padding: 0 20px;
}
.navLeft{
width: 230px;
height: 100%;
}
.sidebarDocker{
background: #1f2637;
}
.sidebarBox{
    padding-top: 20px;
    color: #cfd0d2;
}
</style>
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
