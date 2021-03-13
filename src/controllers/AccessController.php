<?php

namespace baseapi\controllers;

use BaseApi;
use baseapi\base\Controller;
use baseapi\models\LoginForm;
use yii\web\Response;
use baseapi\helpers\BaseApiHelper as Helper;

class AccessController extends Controller
{


    /**
     * Apps will post to this action to login
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if (empty($_POST)) {
            return $this->renderTemplate("login/login_form.twig");
        }

        // The $model->load method second parameter is blank because we are not passing in a form name
        if ($model->load(BaseApi::$app->request->post(),'') && $model->login()) {

            $user = BaseApi::$app->user->identity;

            $this->redirect("/dashboard/");

        } else {
            return $this->renderTemplate("login/login_form.twig", ["error" => "Login Failed"]);
        }

    }


    public function actionLogout()
    {
        BaseApi::$app->user->logout();
        $this->redirect("/access/login");
    }

}
