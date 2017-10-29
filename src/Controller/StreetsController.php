<?php
namespace App\Controller;

use App\Controller\AppController;

class StreetsController extends AppController
{

	public function isAuthorized($user = null) {
		parent::isAuthorized($user);
		$action = $this->request->params['action'];
		if ($user['role'] == "admin") {
			return true;
		} else {
			$this->Flash->error(__("Action invalide."));
			return false;
		}
	}

    public function index()
    {
        $this->paginate = [
			'order'=>['Streets.name_fr'=>'ASC']
        ];
        $streets = $this->paginate($this->Streets);

        $this->set(compact('streets'));
        $this->set('_serialize', ['streets']);
    }

    public function view($id = null)
    {
        $street = $this->Streets->get($id);

        $this->set('street', $street);
        $this->set('_serialize', ['street']);
    }

    public function add()
    {
        $street = $this->Streets->newEntity();
        if ($this->request->is('post')) {
            $street = $this->Streets->patchEntity($street, $this->request->getData());
            if ($this->Streets->save($street)) {
                $this->Flash->success(__('The street has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The street could not be saved. Please, try again.'));
        }
        $this->set(compact('street'));
        $this->set('_serialize', ['street']);
		$this->render('edit');
    }

    public function edit($id = null)
    {
        $street = $this->Streets->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $street = $this->Streets->patchEntity($street, $this->request->getData());
            if ($this->Streets->save($street)) {
                $this->Flash->success(__('The street has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The street could not be saved. Please, try again.'));
        }
        $this->set(compact('street'));
        $this->set('_serialize', ['street']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $street = $this->Streets->get($id);
        if ($this->Streets->delete($street)) {
            $this->Flash->success(__("Cette rue est supprimée. Cela n'impacte pas les utilisateurs ayant déjà choisi cette rue."));
        } else {
            $this->Flash->error(__('The street could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
