<?php

namespace App\Controllers;

class Attendance extends MainController
{
    /**
     * Const of situation equals a finished
     */
    protected const SITUATION_FINISHED = 99;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\Attendance();
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
    public function getAll(){
        return json_encode($this->model
            ->select('
                attendance.attendance_id,
                MAX(person.company_name) as person_company_name,
                MAX(person.phone) as person_phone,
                MAX(attendance.description) as report,
                MAX(attendance.start_date) as start_date,
                MAX(attendance_event.situation) as situation,
                MAX(attendance_event.created_at) as event_created_at,
                MAX(attendance_event.description) as event_description,
                MAX(user_event.name) as event_user_name')
            ->join('person', 'attendance.person_id = person.person_id', 'inner')
            ->join('attendance_reason', 'attendance.person_id = person.person_id', 'inner')
            ->join('attendance_event', 'attendance.attendance_id = attendance_event.attendance_id', 'left')
            ->join('user as user_event', 'attendance_event.user_id = user_event.user_id', 'inner')
            ->where('attendance.end_date', null)
            ->where('attendance.user_id', $this->userId)
            ->groupBy('attendance.attendance_id')
            ->findAll());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $attendanceId = $this->request->getVar('attendance_id');

        // Instance of a user from post
        switch ($attendanceId){
            case true:
               $attendance = $this->model->find($attendanceId);
                break;

            default:
                $attendance = new \App\Entities\Attendance();
                break;
        }

        $attendance->fill([
            'situation' => $this->request->getVar('situation'),
            'start_date' => $this->request->getVar('start_date'),
            'end_date' => $this->request->getVar('end_date'),
            'description' => $this->request->getVar('description'),
            'person_id' => $this->request->getVar('person_id'),
            'user_id' => $this->request->getVar('user_id'),
            'attendance_reason_id' => $this->request->getVar('attendance_reason_id'),
            'attendance_scheduling_id' => $this->request->getVar('attendance_scheduling_id')]
        );

        // Save data
        $this->model->save($attendance);
    }
}