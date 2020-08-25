<?php

namespace App\Controllers;

use CodeIgniter\Model;
use Error;

abstract class MainController extends BaseController
{
    /**
     * @var model of a database
     */
    protected \CodeIgniter\Model $model;

    /**
     * @var userId
     */
    protected $userId;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->userId = session()->get('user_id');
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
     * Save data to database
     */
    public function save(): \CodeIgniter\HTTP\RedirectResponse
    {
        try {
            // Call method to implement save
            $this->savePartial();

            // Send user message
            $this->sendUserNotification('sucess', "Registro salvo com sucesso");
        } catch (Error $error) {
            // Send user message
            $this->sendUserNotification('error', "Ocorreu um erro salvar o registro: { $error->getMessage() }");
        } finally {
            return redirect()->to($this->getIndexRoute());
        }
    }

    /**
     * Save data to database
     */
    abstract public function savePartial(): void;

    /**
     * Delete register to database
     */
    public function delete($objectId): void
    {

        try {
            // Call method to remove partial's objects
            $this->deletePartial($objectId);

            // Call delete model method
            $this->model->delete($objectId);

            // Send user message
            $this->sendUserNotification('sucess', "Registro {$objectId} excluído com sucesso");
        } catch (Error $error) {
            // Send user message
            $this->sendUserNotification('error', "Ocorreu um erro remover o registro: { $error->getMessage() }");
        }
    }

    /**
     * Delete data to database
     */
    public function deletePartial($objectId): void
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
                throw new Error('Type not found');
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
