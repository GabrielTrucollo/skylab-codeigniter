<?php

namespace App\Controllers;
class User extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\User();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/user/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('user/index');
    }

    /**
     * Get all registers
     */
    public function getAll(){
        return json_encode($this->model->select('user_id, doc_cpf, name, user_administrator, email')->findAll());
    }

    /**
     * Get all registers
     */
    public function getAllActive(){
        return json_encode($this->model->select('user_id, name')->findAll());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $userId = $this->request->getVar('user_id');

        // Instance of a user from post
        switch ($userId){
            case true:
               $user = $this->model->find($userId);
                break;

            default:
                $user = new \App\Entities\User();
                break;
        }

        $user->fill([
            'name' => $this->request->getVar('name'),
            'doc_cpf' => $this->request->getVar('doc_cpf'),
            'email' => $this->request->getVar('email'),
            'user_administrator' => $this->request->getVar('user_administrator')]
        );

        // Save data
        $this->model->save($user);
    }

    /**
     * Show login view
     */
    public function loginIndex(): void
    {
        echo view('user/login/index');
    }

    /**
     * Validate doc_cpf and redirect to page of a login
     */
    public function loginValidateCpf() : \CodeIgniter\HTTP\RedirectResponse
    {
        $cpf = $this->request->getVar('doc_cpf');
        if(!$cpf){
            $this->sendUserNotification('error', 'Para iniciar o processo de login é necessário infomar o CPF');
            return redirect()->to($this->getIndexRoute());
        }

        $user = $this->getUserByCpf($cpf);
        if(!$user){
            $this->sendUserNotification('error', 'Nenhum usuário localizado');
            return redirect()->to($this->getIndexRoute());
        }

        session()->set([
            'user_id' => $user->user_id,
            'name' => $user->name,
            'doc_cpf' => $user->doc_cpf,
            'logged_in' => false,
        ]);

        // Redirect to password or new password page
        switch ($user->password)
        {
            case true:
                return redirect()->to('/user/login/password-required');

            default:
                return redirect()->to('/user/login/password-new');
        }
   }

    /**
     * Show login view
     */
    public function loginPassword(): void
    {
        echo view('user/login/password-required');
    }

    /**
     * Validate doc_cpf and redirect to page of a login
     */
    public function loginValidatePassword()
    {
        $user = $this->getUserByCpf(session()->get('doc_cpf'));
        if(!$user){
            $this->sendUserNotification('error', 'Nenhum usuário localizado');
            return redirect()->to($this->getIndexRoute());
        }

        if(!password_verify($this->request->getVar('password'), $user->password))
        {
            $this->sendUserNotification('error', 'Senha informada está incorreta!');
            return redirect()->to('/user/login/password-required');
        }

        session()->set([
            'user_id' => $user->user_id,
            'doc_cpf' => $user->doc_cpf,
            'name' => $user->name,
            'administrator' => $user->user_administrator == 1,
            'logged_in' => true,
        ]);

        $this->sendUserNotification('info', 'Bem vindo, desejamos um ótimo dia!');
        return redirect()->to(base_url());
    }

    /**
     * Show login view
     */
    public function loginNewPassword(): void
    {
        echo view('user/login/password-new');
    }

    /**
     * Validate doc_cpf and redirect to page of a login
     */
    public function loginSaveNewPassword()
    {
        $user = $this->model->find($this->userId);
        if(!$user){
            $this->sendUserNotification('error', 'Nenhum usuário localizado');
            return redirect()->to($this->getIndexRoute());
        }

        if($user->password)
        {
            $this->sendUserNotification('error', 'Opção disponível apenas para usuários que não possúem uma senha informada');
            return redirect()->to($this->getIndexRoute());
        }

        $password = $this->request->getVar('password');
        if(!$password){
            $this->sendUserNotification('error', 'Nenhuma senha foi informada!');
            return redirect()->to($this->getIndexRoute());
        }

        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $this->model->save($user);

        // Set data to session
        session()->set([
            'user_id' => $user->user_id,
            'doc_cpf' => $user->doc_cpf,
            'administrator' => $user->user_administrator == 1,
            'name' => $user->name,
            'logged_in' => true,
        ]);

        $this->sendUserNotification('success', 'Bem vindo, guarde sua senha ela será solicitada nos proximos acessos');
        return redirect()->to(base_url());
    }

    public function logOut(){
        session()->destroy();
        return redirect()->to(base_url());
    }

     /**
     * get user by doc_cpf
     * @param string $cpf cpf of a user
     * @return object User
     */
    private function getUserByCpf(string $cpf) : \App\Entities\User
    {
        return $this->model->where('doc_cpf', $cpf)->limit('1')->first();
    }
}