<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Routing\Router;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[] paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
	
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['home', 'view', 'user', 'category']);
    }
	
	public function isAuthorized($user = null)
	{
		parent::isAuthorized($user);
		if ($user['role'] == "admin") {
			return true;
		}
		$action = $this->request->params['action'];
		if (in_array($action, ['edit', 'delete'])) {
			if ($id = $this->request->getParam('pass.0')) {
				$item = $this->Items->get($id);
				if ($item->user_id == $user['id']) {
					return true;
				} else {
					// The user is not the owner
					$this->Auth->config('authError', "Cette action n'est pas autorisée.");
					return false;
				}
			} else {
				// Missing item id
				return false;
			}
		} elseif ($action == "index") {
			$this->Auth->config('authError', "Cette action n'est pas autorisée.");
			return false;
		} else {
			return true;
		}
	}
	
	/*
		Show all items
	*/
	public function home()
	{
		$items = $this->Items->find('all' , [ 'order'=>['Items.created'=>'DESC'] , 'contain'=>[ 'Users', 'Categories' ] ] );
        $this->paginate = ['limit'=>HOME_LIMIT_ITEMS];
        $this->set(compact('items'), $this->paginate($items));
		$this->set('root',WWW_ROOT);
        $this->set('_serialize', ['items']);
		$this->viewBuilder()->setLayout("packery");
	}
	
	/*
		Show items of the connected user
	*/
	public function mines()
	{
		$items = $this->Items->find('all', ['order'=>['Items.created'=>'DESC'] , 'contain'=>[ 'Categories' ]])
			->where(['user_id'=>$this->Auth->user('id')]);
		$this->set(compact("items"));
        $this->set('_serialize', ['items']);
		$this->viewBuilder()->setLayout("packery");
	}
	
	/*
		Show items of an user
	*/
	public function user($owner_id = null)
	{
		$users = TableRegistry::get('Users');
		$owner = $users->get($owner_id);
		if ($owner->status) {
			// User not active ### Peut-être obsolète : status vérifié au plus haut niveau
			$this->Flash->error(__("Utilisateur inconnu."));
			return $this->redirect(['action'=>"home"]);
		} else {
			$items = $this->Items->find('all' , [ 'order'=>['Items.created'=>'DESC'] , 'contain'=>[ 'Categories' , 'Users' ] ] )
				->where([ 'user_id'=>$owner_id ]);
			$this->set(compact('owner','items'));
			$this->set('root',WWW_ROOT);
			$this->set('_serialize', ['owner','items']);
			$this->viewBuilder()->setLayout("packery");
		}
	}
	
	/*
		Show items of a category
	*/
	public function category($category_id = null) {
		$categories = TableRegistry::get('Categories');
		$category = $categories->get($category_id);
		$items = $this->Items->find( 'all' , [ 'order'=>['Items.created'=>'DESC'] , 'contain'=>[ 'Users' ] ] )
				->where([ 'category_id'=>$category_id ]);
		$this->set(compact('items', 'category'));
		$this->set('root',WWW_ROOT);
		$this->set('_serialize', ['items']);
		$this->viewBuilder()->setLayout("packery");
	}

    public function index()
    {
		// No fusion with categories because a categorie can no more exist
        $this->paginate = [
            'contain' => ['Users','Stats'],
			'order'=>['Items.created'=>'DESC']
        ];
        $items = $this->paginate($this->Items);
		// Find categories separately
		$categories = $this->Items->Categories->find('list');
		$categories = $categories->toArray();
        $this->set(compact('items', 'categories'));
        $this->set('_serialize', ['items', 'categories']);
		$this->viewBuilder()->setLayout("full-width");
    }

    /*
		View one item
	*/
    public function view($id = null)
    {
		$error = false;
        $item = $this->Items->get($id, [
            'contain' => ['Categories', 'Users', 'Stats']
        ]);
		if ($this->request->is('post')) {
			if ($this->isItHuman()) {
				// Send message
				$message = trim(strip_tags($this->request->getData('message')));
				if (strlen($message) < 30) {
					$this->Flash->error(__("Votre message est vide ou trop court."));
					$error = true;
				}
				if (!$error) {
					$email = new Email();
					if ($this->Auth->user('id') !== null) {
						// Connected user
						$email->replyTo([$this->Auth->user('username') => $this->Auth->user('alias')]);
						$applicant = $this->Auth->user('alias');
						$applicantEmail = $this->Auth->user('username');
					} else {
						// Not connected
						$applicant = trim(strip_tags($this->request->getData('name')));
						$applicantEmail = trim(strip_tags($this->request->getData('email')));
						if ($applicant == "" or $applicantEmail == "") {
							$this->Flash->error(__("Veuillez donner votre nom et votre email."));
							$error = true;
						} elseif (!isItEmail($applicantEmail)) {
							$this->Flash->error(__("Votre adresse email n'est pas valide."));
							$error = true;
						} else {
							$email->replyTo([$applicantEmail => $applicant]);
						}
					}
				}
				if (!$error) {
					// Send email
					$email
						->setTemplate('contact_item_'.LG)
						->viewVars([
							'owner' => $item->user->alias, 
							'applicant' => $applicant,
							'email' => $applicantEmail,
							'item_title' => $item->title, 
							'item_link' => Router::url("/items/view/".$item->id, true), 
							'message' => $message])
						->to($item->user->username)
						->subject(__("{0} : message pour votre annonce {1}" , SITE_NAME , $item->title ))
						->send();
					// Count stats
					$stats = TableRegistry::get('Stats');
					$stat = $stats->get($item->stat->id);
					$stat->contacts++;
					$stats->save($stat);
					// Send copy to applicant
					$email
						->setTemplate('contact_item_copy_'.LG)
						->viewVars([
							'owner' => $item->user->alias, 
							'applicant' => $applicant,
							'item_title' => $item->title, 
							'item_link' => Router::url("/items/view/".$item->id, true), 
							'message' => $message])
						->to($applicantEmail)
						->replyTo("noreply@".DOMAIN_NAME)
						->subject(__("{0} : votre message pour l'annonce {1}" , SITE_NAME , $item->title ))
						->send();
					// Reset form
					$this->request->data('message', "");
					// Completed
					$this->Flash->success(__("Votre message a été envoyé à {0}." , $item->user->alias ));
				}
			}
		}
		$item->state_label = $this->getStateLabel($item->state);
        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
			$item->user_id = $this->Auth->user('id');
			$filesResults = $this->uploadFiles('clientFiles', $this->request->getData('image'));
			if (isset($filesResults['urls'][0])) {
				$item->image_1_url = $filesResults['urls'][0];
				if (isset($filesResults['urls'][1])) {
					$item->image_2_url = $filesResults['urls'][1];
					if (isset($filesResults['urls'][2])) {
						$item->image_3_url = $filesResults['urls'][2];
					}
				}
			}
			if (isset($filesResults['errors'])) {
				$this->Flash->error($filesResults['errors'][0]);
			} elseif ($this->Items->save($item)) {
				// Send email to admin
				$email = new Email();
				$email
					->setTo($this->getAdminEmails())
					->setTemplate('item_added_'.LG)
					->viewVars([
						'alias' => $this->Auth->user('alias'), 
						'title' => $item->title, 
						'description' => $item->description,
						'url' => Router::url("/items/view/".$item->id, true)])
					->subject(SITE_NAME." : nouvelle annonce ".$item->title)
					->send();
                $this->Flash->success(__('Votre annonce est en ligne.'));
				// Create stats line
				$stats = TableRegistry::get('Stats');
				$stat = $stats->newEntity();
				$stat->user_id = $this->Auth->user('id');
				$stat->item_id = $item->id;
				$stats->save($stat);
				// Completed
                return $this->redirect(['action' => 'mines']);
            } else {
            	$this->Flash->error(__("Aïe ! L'annonce n'a pas pu être publiée. Ré-essayez et si le problème persiste contactez-nous (lien en bas à droite)."));
			}
        }
        $categories = $this->Items->Categories->find('list', ['valueField'=> function($category) { return $category->title." (".lcfirst($category->description).")"; } ]);
        $this->set(compact('item', 'categories'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id=null, $owner=null)
    {
		$admin = isset($owner); // owner in url -> administration
        $item = $this->Items->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			// Get new data
            $item = $this->Items->patchEntity($item, $this->request->getData());	
			$filesResults = $this->uploadFiles('clientFiles', $this->request->getData('image'));
			// Messages
			if (isset($filesResults['errors'])) {
				$this->Flash->error($filesResults['errors'][0]);
			} else {
				// 1) $filesResults contains 0 to 3 files : fill its in empty file-x-url
				if ($filesResults and !isset($filesResults['errors'])) {
					foreach ($filesResults['urls'] as $fileUrl) {
						if (!$item->image_1_url) {
							$item->image_1_url = $fileUrl;
						} elseif (!$item->image_2_url) {
							$item->image_2_url = $fileUrl;
						} elseif (!$item->image_3_url) {
							$item->image_3_url = $fileUrl;
						}
						if (isset($imagesToDelete[$fileUrl])) {
							unset($imagesToDelete[$fileUrl]); // Keep this file
						}
					}
				}
				// 2) Old files, to delete
				$filesToDelete = $item->extractOriginalChanged(['image_1_url','image_2_url','image_3_url']);
				// 3) Shift files if necessary
				if (!$item->image_1_url) {
					if ($item->image_2_url) {
						$item->image_1_url = $item->image_2_url;
						$item->image_2_url = false;
					} elseif ($item->image_3_url) {
						$item->image_1_url = $item->image_3_url;
						$item->image_3_url = false;
					}
				}
				if (!$item->image_2_url and $item->image_3_url) {
					$item->image_2_url = $item->image_3_url;
					$item->image_3_url = false;
				}
            	if ($this->Items->save($item)) {
					// 4) Delete old files
					foreach ($filesToDelete as $fileToDelete) {
						if ($fileToDelete != "") unlink (WWW_ROOT.$fileToDelete);
					}
					// Message
					$this->Flash->success(__("L'annonce est modifiée."));
					if ($admin) {
						return $this->redirect(['action' => 'index']);
					} else {
						return $this->redirect(['action' => 'mines']);
					}
            	}
            	$this->Flash->error(__('The item could not be saved. Please, try again.'));
			}
        }
        $categories = $this->Items->Categories->find('list');
        $this->set(compact('item', 'categories', 'admin', 'owner'));
        $this->set('_serialize', ['item']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
		if ($item->image_1_url) unlink(WWW_ROOT.$item->image_1_url);
		if ($item->image_2_url) unlink(WWW_ROOT.$item->image_2_url);
		if ($item->image_3_url) unlink(WWW_ROOT.$item->image_3_url);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__("L'annonce est supprimée."));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }
		
	private function getStateLabel($state_id) {
		$stateLabels = array('new'=>__('Comme neuf'), 'used'=>__('Usagé'), 'broken'=>__('À réparer'));
		if (isset($stateLabels[$state_id])) {
			return $stateLabels[$state_id];
		} else {
			return false;
		}
	}
	
}
