<?php

namespace App\Controllers;

class AttendanceType extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\AttendanceType();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/attendance-type/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('attendance_type/index');
    }

    /**
     * Get all registers
     */
    public function getAll(){
        return json_encode($this->model->select('attendance_type_id, description, status')->findAll());
    }

    /**
     * Get all registers
     */
    public function getAllActive(){
        return json_encode($this->model
            ->select('attendance_type_id, description')
            ->where('status', self::REGISTER_ACTIVED)
            ->findAll());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $type = $this->request->getVar('attendance_type_id');

        // Instance of a user from post
        switch ($type){
            case true:
               $attendanceType = $this->model->find($type);
                break;

            default:
                $attendanceType = new \App\Entities\AttendanceType();
                break;
        }

        $attendanceType->fill([
            'description' => $this->request->getVar('description'),
            'status' => $this->request->getVar('status')]
        );

        // Save data
        $this->model->save($attendanceType);
    }
}