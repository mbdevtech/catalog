<?php

namespace Application\Controllers;

use DevNet\Web\Mvc\Controller;
use DevNet\Web\Mvc\IActionResult;

class CatalogController extends Controller
{
    public function index(): IActionResult
    {
        return $this->view();
    }

    public function advert(): IActionResult
    {
        return $this->view();
    }

    public function categories(): IActionResult
    {
        return $this->view();
    }
}
