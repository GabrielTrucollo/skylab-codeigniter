<?php

namespace App\Controllers;

class Dashboard extends MainController
{
    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/';
    }

    /**
     * Show main view
     */
    public function index(): void{
        echo view('includes/header');
        echo view('user/login/password-new');
        echo view('includes/footer');
        echo view('includes/notification');
    }

    /**
     * Save data to database
     */
    public function savePartial(): void
    {

    }
}