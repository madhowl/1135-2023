<?php

declare(strict_types=1);


namespace App\Service;


use App\Core\Pagination;
use App\Model\UserModel;

class UserService implements ServiceInterface
{
    use Pagination;
    public UserModel $model;

    public function __construct(UserModel $model)
    {
        $this->model = $model;
    }
    /**
     * @inheritDoc
     */
    public function index($currentPage = 1): array
    {
        $users = [];
        $count = $this->model->count();
        $this->totalRows = $count;
        $this->currentPage = $currentPage;
        $offset = ($currentPage - 1) * $this->perPage;
        $users['users'] = $this->model->paginate($this->perPage, $offset);
        $users['pagination'] = $this->createLinks();
        return $users;
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function store(array $properties)
    {
        // TODO: Implement store() method.
    }

    /**
     * @inheritDoc
     */
    public function show(int $id)
    {
        return $this->model->getCurentUser($id);
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id)
    {
        // TODO: Implement edit() method.
    }

    /**
     * @inheritDoc
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function destroy(int $id)
    {
        // TODO: Implement destroy() method.
    }


    public function UserSignIn(ServerRequestInterface $request): ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $user = $this->getUserByEmail($requestBody['email']);
        if (empty($user)){
//            return $this->responseWrapper('User not found...');
            $this->setMessage('Пользователь не найден ...', 'error');
            return $this->goUrl('/admin');
        }else{
            if (password_verify($requestBody['password'],$user['password']))
            {
                //return $this->responseWrapper('oki');
                //$this->setUser($user);
                $this->signIn($user['username'],$user['id']);
                $this->setMessage('Привет '.$user['username'].'. Рады снова тебя видеть ;)');
                $this->sendMail(
                    'From Admin Panel',
                    'Привет '.$user['username'].'. Рады снова тебя видеть ;)',
                    '1@1.ru');
                return $this->goUrl('/admin');
            }else{
                //$r = $this->responseWrapper('Неверный пароль');
                $this->setMessage('Неверный пароль ...', 'error');
                return $this->goUrl('/admin');
                //dd($r);
            }
        }

    }

    public function userLogOut(ServerRequestInterface $request): ResponseInterface
    {
        $this->sendMail(
            'From Admin Panel',
            'Пока '.  $_SESSION['username'].'. Возвращайся, я буду скучать ;)',
            '1@1.ru');
        $this->signOut();
        return $this->goUrl('/admin');
    }

    public function UserSignUp(ServerRequestInterface $request): ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $rules = [
            'username' => [
                'required',
                'alpha',
                'min_length(5)',
                'max_length(50)'
            ],
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
                'min_length(5)',
                'max_length(50)',
                'equals(:password_verify)'
            ],
            'password_verify' => [
                'required'
            ]
        ];
        $validation_result = Validator::validate($requestBody, $rules);
        if ($validation_result->isSuccess() == true) {
            $user = $this->getUserByEmail($requestBody['email']);
            if (empty($user)){
                $hash = $this->tokenGenerator();
                $host = $_SERVER['HTTP_ORIGIN'].'/';
                $user = $this->Model->create('users');
                $user->username = $requestBody['username'];
                $user->email = $requestBody['email'];
                $user->password = password_hash($requestBody['password'], PASSWORD_DEFAULT);
                $user->avatar = '/files/files/users/avatarka-standoff.jpg';
                $user->admin = 0;
                $user->verification_token = $hash;
                $user->confirmed = 0;
                $user->save();
                $this->setMessage('Для завершения регистрации вам отправлено письмо. Подтвердите вашу почту перейдя по ссылке в письме');
                $link = $host.'confirm/'.$requestBody['email'].'/'.$hash;
                $this->sendMail(
                    'Завершение регистрации',
                    'Для завершения регистрации на ресурсе '.$host.' подтвердите вашу почту перейдя по <a href="'.$link.'" >ссылке</a>.' ,
                    $requestBody['email']);
                return $this->goUrl('/signin');
            } else {
                $this->setMessage('Email is used ;(', 'error');
                return $this->goUrl('/signup');
            }
        }else{
            $this->setMessage($validation_result->getErrors(), 'error');
            return $this->goUrl('/signup');
        }
    }

    public function showForgotPasswordForm(ServerRequestInterface $request): ResponseInterface
    {
        $message = $this->getMessage();
        $html = $this->View->ShowForgotPasswordForm($message);
        return $this->responseWrapper($html);
    }

    public function setNewUserPassword(string $email)
    {
        $user = $this->Model->find('users')
            ->where('email = :email')
            ->setParameter('email',$email)
            ->first();
        $new_password = $this->passwordGenerator();
        $user->password = password_hash($new_password, PASSWORD_DEFAULT);
        $user->save();
        return $new_password;
    }

    public function hashGenerator(string $email):string
    {
        return $hash = password_hash($email.time(), PASSWORD_DEFAULT);
    }

    public function tokenGenerator():string
    {
        $token = openssl_random_pseudo_bytes(16);
        return $token = bin2hex($token);
    }

    public function passwordGenerator():string
    {
        $password_length = rand(8, 16);
        $chars = '#qazxswedcvfrtgbnhyujmkiolp@*1234567890!$QAZXSWEDCVFRTGBNHYUJMKIOLP';
        $size = strlen($chars) - 1;
        $password = '';
        while($password_length--) {
            $password .= $chars[random_int(0, $size)];
        }
        return $password;
    }

    public function forgotUserPassword(ServerRequestInterface $request): ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $host = $_SERVER['HTTP_ORIGIN'].'/';
        $user = $this->getUserByEmail($requestBody['email']);
        if (empty($user)){
            $this->setMessage('Пользователь не найден ...', 'error');
            return $this->goUrl('/admin');
        }else{
            $hash = $this->tokenGenerator();
            $link = $host.'password-reset/'.$requestBody['email'].'/'.$hash;
            $password_resets = $this->Model->create('password_resets');
            $password_resets->email = $requestBody['email'];
            $password_resets->token = $hash;
            $password_resets->expiration_date = time()+10800;
            $password_resets->confirmed = 0;
            $password_resets->save();

            $this->setMessage('Ссылка для востоновления пароля отправлена на указанный Email');
            $this->sendMail(
                'Востановление пароля',
                'Востановление пароля для  '.$user['email'].'  <a href="'.$link.'" >link</a>' ,
                $user['email']);
            return $this->goUrl('/admin');

        }
        return dd($requestBody['email']);
    }

    public function confirmEmail(ServerRequestInterface $request, array $arg): ResponseInterface
    {
        $user = $this->Model->find('users' )
            ->where('verification_token = :token')
            ->setParameter('token',$arg['token'])
            ->first();
        if (empty($user->getProperties())){
            $this->setMessage('Что-то пошло не так', 'error');
            return $this->goUrl('/');
        }else{
            if ($user->email == $arg['email'] and $user->confirmed == 0){
                $user->confirmed = time();
                $user->save();
                $this->setMessage('Регистрация закончена. Войдите под своими учетными данными.');
                return $this->goUrl('/admin');
            };
        };
    }

    public function passswordReset(ServerRequestInterface $request, array $arg): ResponseInterface
    {
        $password_reset = $this->Model->find('password_resets' )
            ->where('token = :token')
            ->setParameter('token',$arg['token'])
            ->first();
        if (empty($password_reset->getProperties())){
            $this->setMessage('нет такого токена', 'error');
            return $this->goUrl('/admin');
        }else{
            if (
                $password_reset->email == $arg['email'] and
                $password_reset->confirmed == 0
            ){
                if ($password_reset->expiration_date < time()) {
                    $this->setMessage('токен прасрочен', 'error');
                    return $this->goUrl('/admin');
                }else {
                    $password_reset->confirmed = time();
                    $password_reset->save();
                    $new_password = $this->setNewUserPassword($arg['email']);
                    $this->setMessage('Пароль сброшен успешно. Новый пароль отправлен вам на email');
                    $this->sendMail(
                        'Новый пароль',
                        'Ваш новый пароль -> '.$new_password,
                        $arg['email']);
                    return $this->goUrl('/admin');
                }
            }elseif($password_reset->email != $arg['email']){
                $this->setMessage('токен не совпадает с  email', 'error');
                return $this->goUrl('/admin');
            }elseif ($password_reset->confirmed != 0){
                $this->setMessage('этот токен уже использовался', 'error');
                return $this->goUrl('/admin');
            }
        };
    }
}