<?php

namespace App\Controllers;
use Error;

class ClientSoftwareUpdate extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\ClientSoftwareUpdate();
        $this->clientModel = new \App\Models\Client();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/client-software-update/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('person/client/software_update/index');
    }

    /**
     * Get all registers
     */
    public function getAll(){
        return json_encode($this->model
            ->select('
                MAX(person_software_update_id) as person_software_update_id,
                MAX(version) as version,
                MAX(person.company_name) as client,
                MAX(software.name) as software,
                MAX(person_software_update.created_at) as date,
                MAX("user".name) as user_name')
            ->join('person', 'person_software_update.person_id = person.person_id', 'INNER')
            ->join('software', 'person_software_update.software_id = software.software_id', 'INNER')
            ->join('"user"', 'person_software_update.user_id = "user".user_id', 'INNER')
            ->groupBy('person_software_update.person_id')
            ->findAll());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $softwareUpdateId = $this->request->getVar('person_software_update_id');

        // Instance of a object to save
        switch ($softwareUpdateId){
            case true:
               $softwareUpdate = $this->model->find($softwareUpdateId);
                break;

            default:
                $softwareUpdate = new \App\Entities\ClientSoftwareUpdate();
                break;
        }

        $client = $this->clientModel
            ->where('person_id', $this->request->getVar('person_id'))
            ->limit(1)
            ->first();
        if(!$client->software_id){
            throw new Error("Cliente selecionado não possuí nenhum software informado por favor verifique o cadastro do mesmo!");
        }

        $softwareUpdate->fill([
            'person_id' => $this->request->getVar('person_id'),
            'software_id' => $client->software_id,
            'user_id' => $this->userId,
            'version' => $this->request->getVar('version')]
        );

        // Save data
        $this->model->save($softwareUpdate);
    }
}