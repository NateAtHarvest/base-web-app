<?php

namespace baseapi\web;

use baseapi\base\Controller;
use baseapi\helpers\BaseApiHelper as Helper;

class PrivateContentController extends Controller {


    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        if (Helper::getUser() == "") {
            $this->redirect("/access/login");
        }

    }


}
