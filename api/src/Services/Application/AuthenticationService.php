<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.5.2019 г.
 * Time: 18:51
 */

namespace WatchApp\Services\Application;


use WatchApp\Core\MVC\Session;
use WatchApp\Exceptions\ApplicationException;
use WatchApp\Models\DB\User\User;
use WatchApp\Repositories\User\UsersRepository;

class AuthenticationService implements AuthenticationServiceInterface
{
    const IS_ACTIVE = '1';

    private $session;

    private $userRepository;

    private $encryptionService;

    public function __construct()
    {
        $this->session = Session::instance($_SESSION);
        $this->userRepository = new UsersRepository();
        $this->encryptionService = new BCryptEncryptionService();
    }

    public function isAuthenticated(): bool
    {
        return $this->session->isExists('id');
    }

    public function logout()
    {
        $this->session->destroy();
    }

    public function getUserId()
    {
        return $this->session->get('id');
    }

    public function login($email, $password)
    {
        if (empty($email)) {
            throw new ApplicationException('Email can not be empty!');
        }

        if (empty($password)) {
            throw new ApplicationException('Password con not be empty!');
        }

        if (strlen($password) < 6) {
            throw new ApplicationException('Password can not be less then 6 symbols!');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ApplicationException('Email is not valid');
        }

        /**
         * @var User[] $row
         */
        $row = $this->userRepository->findByCondition(['email' => $email], User::class);

        if (empty($row)) {
            throw new ApplicationException('Invalid credentials!');
        }

        if (!$this->encryptionService->verify($password, $row[0]->getPassword())) {
            throw new ApplicationException('Invalid credentials!');
        }

        if ($row[0]->getIsActive() !== self::IS_ACTIVE) {
            throw new ApplicationException('User is not active!');
        }

        $this->session->set('id', $row[0]->getId());

        return [
            'session_id' => session_id(),
            'user_id' => $row[0]->getId()
        ];
    }
}