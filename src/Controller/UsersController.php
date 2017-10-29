<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\I18n\I18n;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to login, register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['register', 'activate', 'login', 'logout']);
    }
	
	public function isAuthorized($user = null) {
		parent::isAuthorized($user);
		$action = $this->request->params['action'];
		if (in_array($action, ['index', 'add', 'view', 'edit', 'delete' ])) {
			if ($user['role'] == "admin") {
				return true;
			} else {
				$this->Flash->error(__("Action invalide."));
				return false;
			}
		} else {
			return true;
		}
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
		$this->viewBuilder()->setLayout("full-width");
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Items']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function register()
    {
        $user = $this->Users->newEntity();
		$user->role = "user"; // User by default
        if ($this->request->is('post')) {
			$data = $this->request->getData();
			if ($data['password'] != $data['password2']) {
				$this->Flash->error(__("Vous n'avez pas rempli deux fois le même mot de passe"));
			} else {
	            $user = $this->Users->patchEntity($user, $data);
				$confirmCode = "waitForConfirm:".md5(time());
				$user->status = $confirmCode;
				$user->role = "user";
				if ($this->Users->save($user)) {
					// Confirmation email
					$email = new Email();
					$email->to($user->username)
						->setTemplate('register_'.$user->language)
						->viewVars([
							'user' => $user->alias,
							'site_url' => Router::url("/", true), 
							'site_name' => "Donnerie", 
							'confirm_url' => Router::url("/users/activate/".$confirmCode, true)])
						->subject("Donnerie : confirmez votre inscription")
						->send();
					$this->Flash->success(__("Vous êtes enregistré. Un email de confirmation a été envoyé à l'adresse {0}. Cela peut prendre quelques minutes - vérifiez votre dossier des spams.",$user->username));
					return $this->redirect(['controller' => 'items', 'action' => 'home']);
				}
				$errors = $user->errors();
				if (isset($errors['username']['_isUnique'])) {
					$this->Flash->error(__('Cet email est déjà enregistré.'));
				} elseif (isset($errors['alias']['_isUnique'])) {
					$this->Flash->error(__('Ce pseudonyme est hélas déjà pris. Choisissez-en un autre.'));
				} else {
					$this->Flash->error(__('The user could not be saved. Please, try again.'));
				}
			}
        }
		$streetsTable = $this->loadModel('Streets');
		$streets = $streetsTable->find('list');
        $this->set(compact(['user','streets']));
        $this->set('_serialize', ['user','streets']);
    }
	
	public function activate($status) {
		$user = $this->Users->find()->where(['status'=>$status])->first();
		if ($user) {
			$user->status = null;
			if ($this->Users->save($user)) {
				$this->Flash->success("Votre compte est activé : vous pouvez vous connecter.");
			} else {
				debug($errors);
				$this->Flash->error(__('Erreur technique'));
			}
		} else {
			$this->Flash->error("Votre code d'activation n'est pas valide.");
		}
		return $this->redirect(['action' => 'login']);
	}

    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
			if ($user->passwordNew) {
				// New password
				$user->password = $user->passwordNew;
			}
			if ($user->status == "") {
				$user->status = null;
			}
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
		$streetsTable = $this->loadModel('Streets');
		$streets = $streetsTable->find('list');
        $this->set(compact(['user','streets']));
        $this->set('_serialize', ['user','streets']);
    }
	
	public function me()
	{
		$user = $this->Users->get($this->Auth->user('id'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
			if ($user->passwordNew) {
				// New password
				if ($user->passwordNew != $user->passwordConfirm) {
					$this->Flash->error(__('Les deux encodages du mot de passe ne correspondent pas.'));
					return $this->redirect(['action' => 'me']);
				}
				$user->password = $user->passwordNew;
			}
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Modifications enregistrées.'));
			} else {
				$this->Flash->error(__('The user could not be saved.'));
			}
			return $this->redirect(['action' => 'me']);
		}
		$streetsTable = $this->loadModel('Streets');
		$streets = $streetsTable->find('list');
        $this->set(compact(['user','streets']));
        $this->set('_serialize', ['user','streets']);
	}
	
	public function deleteMe() {
	}

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
		// ### Progammer la suppression des annonces
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
				$langIso = $user['language']."_".strtoupper($user['language']);
				$this->request->session()->write('Config.language', $langIso);
				I18n::locale($this->request->session()->read('Config.language'));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
