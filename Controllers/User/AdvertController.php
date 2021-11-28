<?php

namespace Application\Controllers\User;

use DevNet\Web\Controller\AbstractController;
use DevNet\Web\Controller\IActionResult;

class AdvertController extends AbstractController
{
    public function index(): IActionResult
    {
        return $this->view();
    }

    public function add(): IActionResult
    {
        return $this->view();
    }

    public function edit(): IActionResult
    {
        return $this->view();
    }
}
