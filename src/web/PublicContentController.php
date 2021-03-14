<?php

namespace baseapi\web;

use baseapi\base\Controller;
use baseapi\helpers\BaseApiHelper as Helper;

class PublicContentController extends Controller {


    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        
    }


}
