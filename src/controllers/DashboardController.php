<?php

namespace baseapi\controllers;

use BaseApi;
use baseapi\web\PrivateContentController;
use baseapi\helpers\BaseApiHelper as Helper;

class DashboardController extends PrivateContentController {

    public function actionIndex() {
        //BaseApi::dd(Helper::getUser());
        return $this->renderTemplate("dashboard/dashboard.twig");
    }

}