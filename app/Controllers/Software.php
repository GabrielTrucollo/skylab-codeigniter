<?php

namespace App\Controllers;
use http\Exception;

class Software extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\Software();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/software/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('software/index');
    }

    /**
     * Get all registers
     */
    public function getAll(){
        return json_encode($this->model->select('software_id, name, status')->findAll());
    }

    /**
     * Get all actived registers
     */
    public function getAllActive(){
        return json_encode($this->model->select('software_id, name')->where('status', self::REGISTER_ACTIVED)->findAll());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $softwareId = $this->request->getVar('software_id');

        // Instance of a user from post
        switch ($softwareId){
            case true:
               $software = $this->model->find($softwareId);
                break;

            default:
                $software = new \App\Entities\Software();
                break;
        }

        $software->fill([
            'name' => $this->request->getVar('name'),
            'status' => $this->request->getVar('status')]
        );

        // Save data
        $this->model->save($software);
    }
}