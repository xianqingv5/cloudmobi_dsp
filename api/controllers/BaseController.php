<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use api\services\BaseService;

class BaseController extends Controller
{
   public function beforeAction($action)
   {
       if (!parent::beforeAction($action)) {
            return false;
       }

       return true;
   }
}