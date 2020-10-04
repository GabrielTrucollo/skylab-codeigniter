<?php

namespace App\Controllers;

use CodeIgniter\Model;
use Error;

abstract class MainController extends BaseController
{
    /**
     * Return value with register is active
     */
    protected const REGISTER_ACTIVED = 0;

    /**
     * @var model of a database
     */
    protected $model;

    /**
     * @var userId
     */
    protected $userId;

    /**
     * @var userId
     */
    protected $userAdministrator;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->userId = session()->get('user_id');
        $this->userAdministrator = session()->get('administrator');
    }

    /**
     * Show main view
     */
    abstract public function index(): void;

    /**
     * GetIndexRoute
     */
    abstract public function getIndexRoute(): string;

    /**
     * Get all registers active
     * @return string json
     */
    public function getAllActive(){
        return $this->response->setStatusCode('404')->setBody('Atenção!! A chamada do método "getAllActive" não foi implementada. Erro de Desenvolvimento!');
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
                return $this->response->setStatusCode('404')->setBody('Registro '. $objectId .' não foi localizado!');
            }

            return json_encode($register);
        } catch (Error $error) {
            return $this->response->setStatusCode('500')->setBody($error->getMessage());
        }
    }

    /**
     * Save data to database
     */
    public function save()
    {
        try {
            // Call method to implement save
            $this->savePartial();

            // Send user message
            $this->sendUserNotification('success', "Registro salvo com sucesso");
        } catch (Error $error) {
            // Send user message
            $this->sendUserNotification('error', "Ocorreu um erro salvar o registro: " . $error->getMessage() . "");
        } catch (\ReflectionException $e) {
            // Send user message
            $this->sendUserNotification('error', "Ocorreu um erro salvar o registro (Reflection): " . $e->getMessage() . "");
        } finally {
            return redirect()->to($this->getIndexRoute());
        }
    }

    /**
     * Save data to database
     */
    abstract public function savePartial();

    /**
     * Delete register to database
     * @param $objectId
     */
    public function delete($objectId)
    {
        try {
            // Call method to remove partial's objects
            $this->beforeDelete($objectId);

            $register = $this->model->find($objectId);
            if(!$register){
                return $this->response->setStatusCode('404')->setBody("Registro { $objectId } não foi localizado");
            }

            // Call delete model method
            $this->model->delete($objectId);

            // Send user message
            return $this->response->setStatusCode(200)->setBody('Registro {' . $objectId . '} excluído com sucesso');
        } catch (Error $error) {
            // Send user message
            return $this->response->setStatusCode(500)->setBody('Ocorreu um erro remover o registro: {' . $error->getMessage() . '}');
        }
    }

    /**
     * Actions beforeDelete object
     * @param $objectId
     */
    public function beforeDelete($objectId)
    {
    }

    /**
     * Send notification of a user
     * @param string $type accept types 'success, info, information, warn, warning, err, error'
     * @param string $message this is a message send to user
     */
    public function sendUserNotification(string $type, string $message): void
    {
        switch ($type) {
            case 'success':
                session()->setFlashdata('success', $message);
                break;

            case 'information':
            case 'info':
                session()->setFlashdata('info', $message);
                break;

            case 'warning':
            case 'warn':
                session()->setFlashdata('warning', $message);
                break;

            case 'error':
            case 'err':
                session()->setFlashdata('error', $message);
                break;

            default:
                throw new Error('Type {'. $type .'} not found');
        }
    }

    /**
     * Format value field to a string timestamps
     * @param \DateTime $dateTime
     * @return string
     */
    public function formatFieldTimeStamp(\DateTime $dateTime): string
    {
        if (!$dateTime) {
            return '';
        }

        return $dateTime->format('Y-m-d H:i:s');
    }
}
