<?php

namespace baseapi\controllers;

use baseapi\base\Controller;

class HelloController extends Controller {

    public function actionIndex() {

        $data = [
            "title" => "My test page",
            "body" => "Hello World"
        ];

        return $this->renderTemplate("test.twig", $data);

    }

}