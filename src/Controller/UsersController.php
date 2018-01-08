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
		$this->paginate = [
            'contain' => ['Items'],
			'order'=>['username'=>'ASC']
        ];
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
			if ($this->isItHuman()) {
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
							->subject(__("Donnerie : confirmez votre inscription"))
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
						$this->Flash->error(__("Aïe, votre enregistrement a rencontré un problème. Vérifiez que vos données ne présentent pas d'erreur. Si le problème persiste, contactez-nous (lien en bas à droite)."));
					}
				}
			}
        }
		$streetsTable = $this->loadModel('Streets');
		$streets = $streetsTable->find('list', ['order'=>['Streets.name_'.LG=>"ASC"]]);
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
		$streets = $streetsTable->find('list', ['order'=>['Streets.name_'.LG=>"ASC"]]);
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
		$streets = $streetsTable->find('list', ['order'=>['Streets.name_'.LG=>"ASC"]]);
        $this->set(compact(['user','streets']));
        $this->set('_serialize', ['user','streets']);
	}
	
	public function deleteMe() {
	}

    public function delete($id = null)
    {
		$error = false;
        $this->request->allowMethod(['post', 'delete']);
		// Delete user
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user {0} has been deleted.', $user->username));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
			$error = true;
        }
		if (!$error) {
			// Delete his items
			$itemsTable = $this->loadModel('Items');
			$queryItems = $itemsTable->find('all')->where(['user_id = ' => $id]);
			foreach ($queryItems as $item) {
				if ($item->image_1_url) unlink(WWW_ROOT.$item->image_1_url);
				if ($item->image_2_url) unlink(WWW_ROOT.$item->image_2_url);
				if ($item->image_3_url) unlink(WWW_ROOT.$item->image_3_url);
				if (!$itemsTable->delete($item)) {
					$this->Flash->error(__("Problème lors de la suppression de l'annonce {0}", $item->id));
				}
			}
		}
		return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
			if ($this->isItHuman(0)) {
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
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
