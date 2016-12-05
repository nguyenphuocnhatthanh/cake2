<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function login() {
        if ($this->Auth->loggedIn()) {
            $this->Auth->logout();
            die(var_dump('logged in'));

        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                die(var_dump('logged'));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function add() {
          if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        }
    }
}
