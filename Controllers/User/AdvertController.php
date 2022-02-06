<?php

namespace Application\Controllers\User;

use DevNet\Web\Mvc\Controller;
use DevNet\Web\Mvc\IActionResult;

class AdvertController extends Controller
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
