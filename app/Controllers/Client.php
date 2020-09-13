<?php

namespace App\Controllers;

class Client extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\Client();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/client/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('person/client/index');
    }

    /**
     * Get all registers
     */
    public function getAll(){
        return json_encode($this->model
            ->select('person_id, company_name, fantasy_name, doc_cpf_cnpj, phone, email, status')
            ->where('flag_client', true)
            ->findAll());
    }

    /**
     * Get all actived registers
     */
    public function getAllActive(){
        return json_encode($this->model
            ->select('person_id, company_name')
            ->where('flag_client', true)
            ->where('status', self::REGISTER_ACTIVED)
            ->findAll());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $personId = $this->request->getVar('person_id');

        // Instance of a user from post
        switch ($personId){
            case true:
               $person = $this->model->find($personId);
                break;

            default:
                $person = new \App\Entities\Client();
                break;
        }

        $person->fill([
            'status' => $this->request->getVar('status'),
            'company_name' => $this->request->getVar('company_name'),
            'fantasy_name' => $this->request->getVar('fantasy_name'),
            'doc_cpf_cnpj' => $this->request->getVar('doc_cpf_cnpj'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'flag_client' => true,
            'address_street' => $this->request->getVar('address_street'),
            'address_neighborhood' => $this->request->getVar('address_neighborhood'),
            'address_number' => $this->request->getVar('address_number'),
            'address_zipcode' => $this->request->getVar('address_zipcode'),
            'address_city' => $this->request->getVar('address_city'),
            'address_state' => $this->request->getVar('address_state'),
            'address_reference' => $this->request->getVar('address_reference'),
            'software_id' => $this->request->getVar('software_id'),
            'accounting_id' => $this->request->getVar('accounting_id'),
            'payment_type_id' => $this->request->getVar('payment_type_id')]
        );

        // Save data
        $this->model->save($person);
    }
}