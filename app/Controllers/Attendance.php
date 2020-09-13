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
        $this->attendanceEventControler = new AttendanceEvent();
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
                attendance.description as report,
                attendance.start_date as start_date,
                attendance.start_time as start_time,
                MAX(attendance_event.situation) as situation,
                MAX(attendance_event.created_at) as event_created_at,
                MAX(attendance_event.description) as event_description,
                MAX(user_event.name) as event_user_name')
            ->join('person', 'attendance.person_id = person.person_id', 'INNER')
            ->join('attendance_reason', 'attendance.person_id = person.person_id', 'INNER')
            ->join('attendance_event', 'attendance.attendance_id = attendance_event.attendance_id', 'LEFT')
            ->join('user as user_event', 'attendance_event.user_id = user_event.user_id', 'LEFT')
            ->where('attendance.end_date', null)
            ->where('attendance.user_id', $this->userId)
            ->groupBy('attendance.attendance_id')
            ->findAll());
    }

    /**
     * Get register to database
     * @param $objectId
     */
    public function getById($objectId)
    {
        try {
            $register =  $this->model->find($objectId);
            if(!$register){
                return $this->response->setStatusCode('404')->setBody('Registro {'. $objectId .'} não foi localizado!');
            }

            $register->listEvents = $this->attendanceEventControler->getAll($objectId);
            return json_encode($register);
        } catch (Error $error) {
            return $this->response->setStatusCode('500')->setBody($error->getMessage());
        }
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
            'start_date' => $this->request->getVar('start_date'),
            'start_time' => $this->request->getVar('start_time'),
            'description' => $this->request->getVar('description'),
            'person_id' => $this->request->getVar('person_id'),
            'user_id' => $this->userId,
            'attendance_reason_id' => $this->request->getVar('attendance_reason_id')]
        );

        // Save data
        $this->model->save($attendance);
    }
}