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
        $this->model = new \App\Models\User;
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
    }

    /**
     * Save data to database
     */
    public function savePartial(): void
    {
    }

    /**
     * Show login view
     */
    public function loginIndex(): void
    {
        echo view('includes/header');
        echo view('user/login/index');
        echo view('includes/footer');
        echo view('includes/notification');
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
        echo view('includes/header');
        echo view('user/login/password-required');
        echo view('includes/footer');
        echo view('includes/notification');
    }

    /**
     * Validate doc_cpf and redirect to page of a login
     */
    public function loginValidatePassword() : \CodeIgniter\HTTP\RedirectResponse
    {
        $user = $this->getUserByCpf(session()->get('doc_cpf'));
        if(!$user){
            $this->sendUserNotification('error', 'Nenhum usuário localizado');
            return redirect()->to($this->getIndexRoute());
        }

        if(!password_verify($this->request->getVar('password'), $user->password))
        {
            $this->sendUserNotification('error', 'Senha informada está incorreta!');
            return redirect()->to('user/login/password-required');
        }

        session()->set([
            'user_id' => $user->user_id,
            'doc_cpf' => $user->doc_cpf,
            'name' => $user->name,
            'logged_in' => true,
        ]);

        return redirect()->to('/');
    }

    /**
     * Show login view
     */
    public function loginNewPassword(): void
    {
        echo view('includes/header');
        echo view('user/login/password-new');
        echo view('includes/footer');
        echo view('includes/notification');
    }

    /**
     * Validate doc_cpf and redirect to page of a login
     */
    public function loginSaveNewPassword() : \CodeIgniter\HTTP\RedirectResponse
    {
        $user = $this->getUserByCpf(session()->get('doc_cpf'));
        if(!$user){
            $this->sendUserNotification('error', 'Nenhum usuário localizado');
            return redirect()->to($this->getIndexRoute());
        }

        if(!$user->password)
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

        session()->set([
            'user_id' => $user->user_id,
            'doc_cpf' => $user->doc_cpf,
            'name' => $user->name,
            'logged_in' => true,
        ]);

        $this->sendUserNotification('sucess', 'Bem vindo, guarde sua senha ela será solicitada nos proximos acessos');
        return redirect()->to('/');
    }

     /**
     * get user by doc_cpf
     * @param string $cpf cpf of a user
     * @return object
     */
    private function getUserByCpf(string $cpf) :object{
        return $this->model->where('doc_cpf', $cpf)->limit('1')->first();
    }
}