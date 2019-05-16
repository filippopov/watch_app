<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 7:50
 */

namespace WatchApp\Services\User;


use WatchApp\Core\MVC\Session;
use WatchApp\Exceptions\ApplicationException;
use WatchApp\Models\DB\User\User;
use WatchApp\Repositories\User\UsersRepository;
use WatchApp\Services\Application\BCryptEncryptionService;

class UserService
{
    const IS_ACTIVE = 1;

    private $userRepository;

    private $encryptionService;

    private $session;

    public function __construct()
    {
        $this->userRepository = new UsersRepository();
        $this->encryptionService = new BCryptEncryptionService();
        $this->session = Session::instance($_SESSION);
    }

    public function register($email, $password, $repeatPass)
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

        if ($password != $repeatPass) {
            throw new ApplicationException('Passwords mismatch!');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ApplicationException('Email is not valid');
        }

        $rows = $this->userRepository->findByCondition(['email' => $email]);
        if (!empty($rows)) {
            throw new ApplicationException('Email is already taken!');
        }

        $result = $this->userRepository->create([
            'email' => $email,
            'password' => $this->encryptionService->hash($password),
            'is_active' => self::IS_ACTIVE
        ]);

        if (!$result) {
            throw new ApplicationException('Registration failed!');
        }

        /**
         * @var User[] $row
         */
        $row = $this->userRepository->findByCondition(['email' => $email], User::class);

        if (empty($row)) {
            throw new ApplicationException('Registration failed!');
        }

        $this->session->set('id', $row[0]->getId());

        return [
            'session_id' => session_id(),
            'user_id' => $row[0]->getId()
        ];
    }
}