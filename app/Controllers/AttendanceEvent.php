<?php

namespace App\Controllers;

class AttendanceEvent extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\AttendanceEvent();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/attendance/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('attendance/index');
    }

    /**
     * Get all registers
     */
    public function getAll($attendanceId){
        return $this->model
            ->select('attendance_event_id, situation, attendance_event.created_at, user.name as user, attendance_type.description as attendance_type')
            ->join('user', 'attendance_event.user_id = user.user_id', 'INNER')
            ->join('attendance_type', 'attendance_event.attendance_type_id = attendance_type.attendance_type_id', 'INNER')
            ->where('attendance_id', $attendanceId)
            ->findAll();
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $event = $this->request->getVar('attendance_event_id');

        // Instance of a user from post
        switch ($event){
            case true:
               $attendanceEvent = $this->model->find($event);
                break;

            default:
                $attendanceEvent = new \App\Entities\AttendanceEvent();
                break;
        }

        $attendanceEvent->fill([
            'end_date' => $this->request->getVar('end_date'),
            'end_time' => $this->request->getVar('end_time'),
            'description' => $this->request->getVar('description'),
            'user_id' => $this->request->getVar('user_id'),
            'attendance_id' => $this->request->getVar('attendance_id'),
            'attendance_type_id' => $this->request->getVar('attendance_type_id'),
            'situation' => $this->request->getVar('situation')]
        );

        // Save data
        $this->model->save($attendanceEvent);
    }
}