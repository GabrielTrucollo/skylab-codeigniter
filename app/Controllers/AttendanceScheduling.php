<?php

namespace App\Controllers;

class AttendanceScheduling extends MainController
{
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        Parent::__construct();
        $this->model = new \App\Models\AttendanceScheduling();
    }

    /**
     * Return to index route to controller
     */
    public function getIndexRoute(): string
    {
        return '/attendance-scheduling/';
    }

    /**
     * Show main view
     */
    public function index(): void
    {
        echo view('attendance_scheduling/index');
    }

    public function getAll() {
        return json_encode($this->model
            ->select('
                attendance_scheduling_id as id,
                person.company_name as title,
                start_date as start,
                end_date as end')
            ->join('person', 'attendance_scheduling.person_id = person.person_id', 'INNER')
            ->where('user_id', $this->userId)
            ->findAll());
    }

    public function getNewRegister(){
        return json_encode(new \App\Entities\AttendanceScheduling());
    }

    /**
     * Save data to database
     */
    public function savePartial()
    {
        // Get user id of a request
        $Id = $this->request->getVar('attendance_scheduling_id');

        // Instance of a user from post
        switch ($Id){
            case true:
               $attendanceScheduling = $this->model->find($Id);
                break;

            default:
                $attendanceScheduling = new \App\Entities\AttendanceScheduling();
                break;
        }

        $attendanceScheduling->fill([
            'reason' => $this->request->getVar('reason'),
            'start_date' => $this->request->getVar('start_date'),
            'start_hour' => $this->request->getVar('start_hour'),
            'end_date' => $this->request->getVar('end_date'),
            'end_hour' => $this->request->getVar('end_hour'),
            'person_id' => $this->request->getVar('person_id'),
            'user_id' => $this->userId]
        );

        // Save data
        $this->model->save($attendanceScheduling);
    }
}