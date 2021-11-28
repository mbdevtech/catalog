<?php

namespace Application\Controllers;

use DevNet\Web\Controller\AbstractController;
use DevNet\Web\Controller\IActionResult;

class CatalogController extends AbstractController
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
