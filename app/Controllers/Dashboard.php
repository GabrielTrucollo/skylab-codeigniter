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
    }

    /**
     * Save data to database
     */
    public function savePartial(): void
    {

    }
}