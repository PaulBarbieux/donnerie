<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\I18n\I18n;
use Cake\Auth\DefaultPasswordHasher;

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
        $this->Auth->allow(['register', 'activate', 'login', 'logout', 'resetPassword']);
    }
	
	public function isAuthorized($user = null) {
		parent::isAuthorized($user);
		$action = $this->request->getParam('action');
		if (in_array($action, ['index', 'exportEmailsCsv', 'add', 'view', 'edit', 'delete' ])) {
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
	
	public function exportEmailsCsv()
	{
		$users_fr = $this->Users->find('all', array('conditions'=>array('status IS NULL')))->where(array('language'=>"fr"))->select('username');
		$this->set(compact('users_fr'));
		$users_nl = $this->Users->find('all', array('conditions'=>array('status IS NULL')))->where(array('language'=>"nl"))->select('username');
		$this->set(compact('users_nl'));
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
				if (strlen($data['password']) < 8) {
					$this->Flash->error(__("Veuillez donner un mot de passe d'au moins 8 caractères."));
				} elseif ($data['password'] != $data['password2']) {
					$this->Flash->error(__("Vous n'avez pas rempli deux fois le même mot de passe."));
				} else {
					$user = $this->Users->patchEntity($user, $data);
					$confirmCode = "waitForConfirm:".md5(time());
					$user->status = $confirmCode;
					$user->role = "user";
					if ($this->Users->save($user)) {
						// Confirmation email
						$email = new Email();
						$email->setTo($user->username);
						$email->viewBuilder()->setTemplate('register_'.$user->language);
						$email->setViewVars([
								'user' => $user->alias,
								'site_url' => Router::url("/", true), 
								'site_name' => SITE_NAME, 
								'confirm_url' => Router::url("/users/activate/".$confirmCode, true)]);
						$email->setSubject(__("{0} : confirmez votre inscription", SITE_NAME));
						$email->send();
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
				$this->Flash->success(__("Votre compte est activé : vous pouvez vous connecter."));
			} else {
				debug($errors);
				$this->Flash->error(__('Erreur technique'));
			}
		} else {
			$this->Flash->error(__("Votre code d'activation n'est pas valide."));
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
				if (strlen($user->passwordNew) < 8) {
					$this->Flash->error(__("Veuillez donner un mot de passe d'au moins 8 caractères."));
					return $this->redirect(['action' => 'me']);
				} elseif ($user->passwordNew != $user->passwordConfirm) {
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
		$user = $this->Users->get($this->Auth->user('id'));
		if ($this->request->is(['patch', 'post', 'put'])) {
			if ((new DefaultPasswordHasher)->check($this->request->getData('passwordDeleteMe'), $user->password)) {
				if ($this->Users->delete($user)) {
					$this->deleteUserItems($user->id);
					$this->Flash->success(__('Votre compte est supprimé.'));
					return $this->redirect($this->Auth->logout());
				} else {
					$this->Flash->error(__("Un problème technique est survenu. Contactez-nous avec le formulaire en bas à droite."));
				}
			} else {
				$this->Flash->error(__("Le mot de passe ne correspond pas."));
			 }
		}
		$this->set(compact('user'));
        $this->set('_serialize', 'user');
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
			$this->deleteUserItems($id);
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
					$session = $this->request->getSession();
					$session->write('Config.language', $langIso);
					I18n::setLocale($session->read('Config.language'));
					return $this->redirect($this->Auth->redirectUrl());
				}
				$this->Flash->error(__("L'email ou le mot de passe est invalide. Avez-vous bien créé un compte sur notre site ?"));
			}
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
	
	private function deleteUserItems($userId) {
		$itemsTable = $this->loadModel('Items');
		$queryItems = $itemsTable->find('all')->where(['user_id = ' => $userId]);
		foreach ($queryItems as $item) {
			if ($item->image_1_url) unlink(WWW_ROOT.$item->image_1_url);
			if ($item->image_2_url) unlink(WWW_ROOT.$item->image_2_url);
			if ($item->image_3_url) unlink(WWW_ROOT.$item->image_3_url);
			if (!$itemsTable->delete($item)) {
				$this->Flash->error(__("Problème lors de la suppression de l'annonce {0}", $item->id));
			}
		}
	}
	
	public function resetPassword() {
        if ($this->request->is('post')) {
			$session = $this->request->getSession();
			// Get data
			$data = $this->request->getData();
			// Find user
			$user = $this->Users->find()->where([ 'username'=>$data['username'] , 'status IS NULL' ])->first();
			if (!isset($data['resetcode'])) {
				// First pass : email and street
				if ($this->isItHuman()) {
					if ($user) {
						if ($user->street != $data['street']) {
							$this->Flash->error(__("Cette adresse email est inconnue ou ne correspond pas avec la rue."));
						} else {
							// Make a reset code and save it in session
							$resetCode = md5($data['username'].$data['street'].rand(1,9999).time());
							$session->write('resetCode', $resetCode);
							$email = new Email();
							$email->setTo($user->username);
							$email->viewBuilder()->setTemplate('reset_password_'.$user->language);
							$email->setViewVars([
									'user' => $user->alias,
									'site_url' => Router::url("/", true), 
									'site_name' => SITE_NAME, 
									'reset_code' => $resetCode]);
							$email->setSubject(__("{0} : code de renouvellement de mot de passe", SITE_NAME));
							$email->send();
							$this->Flash->success(__("Un code vient de vous être envoyé par email. Voyez les instructions plus bas."));
							$this->set("inputCode", true);
						}
					} else {
						$this->Flash->error(__("Cette adresse email est inconnue ou ne correspond pas avec la rue."));
					}
				}
			} else {
				// Second pass : reset code
				if (trim($data['resetcode']) != $session->read('resetCode')) {
					$this->Flash->error(__("Votre code n'est pas correct."));
				} elseif (strlen($data['password']) < 8) {
					$this->Flash->error(__("Veuillez donner un mot de passe d'au moins 8 caractères."));
				} elseif ($data['password'] != $data['password2']) {
					$this->Flash->error(__("Vous n'avez pas rempli deux fois le même mot de passe."));
				} else {
					$user->password = $data['password'];
					if ($this->Users->save($user)) {
                		$this->Flash->success(__('Votre nouveau mot de passe est enregistré. Vous pouvez vous connecter avec ce nouveau mot de passe.'));
                		return $this->redirect(['action' => 'login']);
            		}
				}
				$this->set("inputCode", true);
			}
		}
		$streetsTable = $this->loadModel('Streets');
		$streets = $streetsTable->find('list', ['order'=>['Streets.name_'.LG=>"ASC"]]);
        $this->set(compact('streets'));
        $this->set('_serialize', 'streets');
	}
	
}
