<?php

namespace App\Controllers;

class AttendanceReason extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\AttendanceReason();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/attendance-reason/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('attendance_reason/index');
    }

    /**
     * Get all registers
     */
    public function getAll(){
        return json_encode($this->model->select('attendance_reason_id, description, status')->findAll());
    }

    /**
     * Get all registers
     */
    public function getAllActive(){
        return json_encode($this->model
            ->select('attendance_reason_id, description')
            ->where('status', self::REGISTER_ACTIVED)
            ->findAll());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $reason = $this->request->getVar('attendance_reason_id');

        // Instance of a user from post
        switch ($reason){
            case true:
               $attendanceReason = $this->model->find($reason);
                break;

            default:
                $attendanceReason = new \App\Entities\AttendanceReason();
                break;
        }

        $attendanceReason->fill([
            'description' => $this->request->getVar('description'),
            'status' => $this->request->getVar('status')]
        );

        // Save data
        $this->model->save($attendanceReason);
    }
}