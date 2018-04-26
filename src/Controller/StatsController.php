<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class StatsController extends AppController
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
		// Items and contacts
        $stats = $this->Stats->find( 'all' );
        $this->set(compact('stats'));
        $this->set('_serialize', ['stats']);
		// Users
		$users = TableRegistry::get('Users');
		$count = $users->find()->count();
		$this->set('countAllUsers',$count);
			$count = $users->find('all', array('conditions'=>array('status IS NOT NULL')))->count();
		$this->set('countUnregisteredUsers',$count);
		// Current items
		$items = TableRegistry::get('Items');
		$count = $items->find()->count();
		$this->set('countCurrentItems',$count);
    }
}
