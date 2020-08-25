<?php

namespace App\Controllers;

use CodeIgniter\Model;
use Error;

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
        echo view('includes/notification');
        echo view('includes/footer');
    }

    /**
     * Save data to database
     */
    public function savePartial(): void
    {

    }
}