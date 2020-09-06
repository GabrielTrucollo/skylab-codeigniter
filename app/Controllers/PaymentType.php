<?php

namespace App\Controllers;

class PaymentType extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\PaymentType();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/payment-type/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('PaymentType/index');
    }

    /**
     * Get all registers
     */
    public function getAll(){
        return json_encode($this->model->select('payment_type_id, description, status')->findAll());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $paymentId = $this->request->getVar('payment_type_id');

        // Instance of a user from post
        switch ($paymentId){
            case true:
               $paymentType = $this->model->find($paymentId);
                break;

            default:
                $paymentType = new \App\Entities\PaymentType();
                break;
        }

        $paymentType->fill([
            'description' => $this->request->getVar('description'),
            'status' => $this->request->getVar('status')]
        );

        // Save data
        $this->model->save($paymentType);
    }
}