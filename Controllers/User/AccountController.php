<?php

namespace Application\Controllers\User;

use DevNet\System\Linq;
use DevNet\System\Type;
use DevNet\System\Collections\ArrayList;
use DevNet\Web\Controller\AbstractController;
use DevNet\Web\Controller\IActionResult;
use DevNet\Web\Controller\Filters\AuthorizeFilter;
use DevNet\Web\Controller\Filters\AntiForgeryFilter;
use Application\Models\LoginForm;
use Application\Models\RegisterForm;
use DevNet\Web\Identity\User;
use DevNet\Entity\EntityContext;
use DevNet\Web\Identity\IdentityManager;
use DevNet\Web\Identity\UserManager;

/**
 * This is an example on how to create registration and login system using claims without SQL database.
 * This example dosen't encrypt your data, so it's not recommanded for production,
 * Use DevNet Identity Manager instead, or encrypt you own data.
 */
class AccountController extends AbstractController
{
    private IdentityManager $Identity;
    private UserManager $Users;
    private EntityContext $DbManager;

    public function __construct(IdentityManager $im, UserManager $users, EntityContext $dbm)
    {
        $this->Identity  = $im;
        $this->Users     = $users;
        $this->DbManager = $dbm;

        $this->filter('index', AuthorizeFilter::class);
        $this->filter('profile', AuthorizeFilter::class);
        $this->filter('login', AntiForgeryFilter::class);
        $this->filter('register', AntiForgeryFilter::class);
    }

    public function index(): IActionResult
    {
        $user = $this->Users->getUser();
        $this->ViewData['Email'] = $user->Username;
        return $this->view();
    }

    public function profile(): IActionResult
    {
        // show profile
        $user = $this->Users->getUser();
        $this->ViewData['Email'] = $user->Username;
        return $this->view();
    }

    public function login(LoginForm $form): IActionResult
    {
        $user = $this->HttpContext->User;

        if ($user->isAuthenticated()) {
            return $this->redirect('/user/account/');
        }

        if (!$form->isValide()) {
            return $this->view();
        }

        $this->Identity->signIn($form->Username, $form->Password, $form->Remember);

        return $this->redirect('/user/account/login');
    }

    public function register(RegisterForm $form): IActionResult
    {
        $this->ViewData['success'] = false;
        if (!$form->isValide()) {
            return $this->view();
        }

        $user = new User();
        $user->Name = $form->Name;
        $user->Username = $form->Email;
        $user->Password = $form->Password;
        $this->Users->create($user);

        $this->ViewData['success'] = true;
        $last = $this->DbManager->Users->last();
        return $this->redirect('/user/account/login');
    }

    public function logout(): IActionResult
    {
        $authentication = $this->HttpContext->Authentication;
        $authentication->SignOut();
        return $this->redirect('/user/account/login');
    }
}
