<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
	
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
		
        $session = $this->request->getSession();
		
		/*
			Authorization
		*/
        $this->loadComponent('Auth', [
			'authenticate' => [
				'Form' => [
					'finder' => 'auth'
				]
			],
            'loginRedirect' => [
                'controller' => 'Items',
                'action' => 'mines'
            ],
            'logoutRedirect' => [
                'controller' => 'Items',
                'action' => 'home'
            ],
			'authorize' => 'Controller',
			'authError' => __("Veuillez vous connecter pour pouvoir faire cette action.")
        ]);
		$this->Auth->allow(['changeLanguage', 'contact']);
		
		/*
			Language
			LG is "fr" or "nl", to use for the name of variables. Exemple : "title_".LG
		*/
		if (LANGUAGES == "fr" or LANGUAGES == "nl") {
			// Only one language set for the site
			define ('MULTI_LG', false);
			if (LANGUAGES == "fr") {
				I18n::setLocale("fr_FR");
				define('LG','fr');
			} else {
				I18n::setLocale("nl_NL");
				define('LG','nl');
			}
		} else {
			define ('MULTI_LG', true);
			if ($session->check('Config.language')) {
				// Get language from user profile (set by language switch)
				I18n::setLocale($session->read('Config.language'));
				define('LG',substr($session->read('Config.language'),0,2));
			} else {
				// Set language based on browser, first fr or nl found (language switch neer clicked)
				$firstLg = false;
				$acceptLanguages = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
				foreach ($acceptLanguages as $browserLg) {
					if (strpos($browserLg,"nl") !== false) {
						$firstLg = "nl";
						break;
					} elseif (strpos($browserLg,"fr") !== false) {
						$firstLg = "fr";
						break;
					}
				}
				if ($firstLg == "nl") {
					I18n::setLocale("nl_NL");
					define('LG','nl');
				} else {
					I18n::setLocale("fr_FR");
					define('LG','fr');
				}
			}
		}
		if (LG == "nl") {
			define ('SITE_NAME',SITE_NAME_NL);
		} else {
			define ('SITE_NAME',SITE_NAME_FR);
		}

		/*
			Categories
		*/
		if (!$session->check('Categories')) {
			$connection = ConnectionManager::get('default');
			$categories = $connection->execute('SELECT id, title_'.LG.' title FROM categories ORDER BY title_'.LG)->fetchAll('assoc');
			$session->write('Categories',$categories);
		}
		
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }	

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
       if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->getType(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
	
	public function isAuthorized($user = null) {
		return true;
	}
	
	public function changeLanguage($language) {
		$session = $this->request->getSession();
		$session->write('Config.language', $language);
		$session->delete('Categories'); // Force reload categories in session
		$this->redirect($this->referer());
	}
	
	public function contact() {
        if ($this->request->is('post')) {
			if ($this->isItHuman(2)) {
				$data = $this->request->getData();
				if (trim($data['district']) == POSTCODE) {
					if (!isset($data['email'])) {
						$data['email'] = $this->Auth->user('username');
						$data['name'] = $this->Auth->user('alias');
					}
					$data['message'] = strip_tags(trim($data['message']));
					$data['url'] = $this->referer();
					$template = "contact_".LG;
					$email = new Email();
					$email->setReplyTo([$data['email'] => $data['name']]);
					$email->viewBuilder()->setTemplate($template);
					$email->setViewVars([
							'email' => $data['email'], 
							'name' => $data['name'], 
							'url' => $data['url'], 
							'message' => nl2br($data['message'])]);
					$email->setTo($this->getAdminEmails());
					$email->setSubject(__("{0} : {1} ({2})", SITE_NAME, $data['subject'], $data['name']));
					$email->send();
					$this->Flash->success(__("Votre message a été envoyé. Merci."));
				} else {
					$this->Flash->error(__("Protection anti-spam : veuillez donner le code postal de notre commune dans le formulaire de contact."));
				}
			}
			$this->redirect($this->referer());
		}
	}
	
	// Detect robot : the form must contain an input "start" set with time() and a hidden input "last_name" (the trap)
	public function isItHuman($delay=2) {
		$human = true;
		if (time() - $this->request->getData('start') < $delay) {
			// Form filled rapidly -> robot !				
			$human = false;
		} elseif ($this->request->getData('last_name') != "") {
			// Hidden input filled -> robot !
			$human = false;
		} elseif ($this->referer() == "" or $this->referer() == "/") {
			// No domain -> robot !
			$human = false;
		} elseif (strpos($this->request->getData('message'),"http://") !== false or strpos($this->request->getData('message'),"https://") !== false) {
			// Site url in the message -> spam !
			$human = false;
		}
		if (!$human and EMAIL_REDIRECT_SPAM !== false) {
			// Alert an administrator
			$postedData = $this->request->getData();
			if (isset($postedData['password'])) $postedData['password'] = "(password)";
			if (isset($postedData['password2'])) $postedData['password2'] = "(password2)";
			Email::deliver(
				EMAIL_REDIRECT_SPAM, 
				SITE_NAME.' : suspicion de spam ('.$postedData['name'].')', 
				"La fonction isItHuman() suspecte un robot ou un spammer derrière cet envoi (".$this->referer().") :<br><br>
				".implode("<br>",$postedData)."<br><br>
				Temps d'encodage : ". (time() - $postedData['start'] . " sec")
			);
		}
		return $human;
	}

	
	/**
	 * uploads files to the server 
	 * http://www.jamesfairhurst.co.uk/posts/view/uploading_files_and_images_with_cakephp
	 * @params:
	 *		$folder 	= the folder to upload the files e.g. 'img/files'
	 *		$formdata 	= the array containing the form files
	 *		$itemId 	= id of the item (optional) will create a new sub folder
	 * @return:
	 *		will return an array with the success of each file upload
	 */
	function uploadFiles($folder, $formdata, $itemId = null) {
	
		$result = false;
		
		// setup dir names absolute and relative
		$folder_url = WWW_ROOT.$folder;
		$rel_url = $folder;
		
		// create the folder if it does not exist
		if(!is_dir($folder_url)) {
			mkdir($folder_url);
		}
			
		// if itemId is set create an item folder
		if($itemId) {
			// set new absolute folder
			$folder_url = WWW_ROOT.$folder.'/'.$itemId; 
			// set new relative folder
			$rel_url = $folder.'/'.$itemId;
			// create directory
			if(!is_dir($folder_url)) {
				mkdir($folder_url);
			}
		}
		
		// List of permitted file types, this is only images but documents can be added
		$permitted = array('image/gif'=>false,'image/jpeg'=>true,'image/pjpeg'=>false,'image/png'=>false);
		
		// First pass : loop through and check file size and types
		foreach($formdata as $file) {
			if ($file['name'] != "") {
				if ($file['error'] == 1) {
					$result['errors'][] = __("{0} est trop grande. Choisissez une autre image ou réduisez celle-ci avec un programme d'image.",$file['name']);
					return $result;
				} elseif (!isset($permitted[$file['type']]) or !$permitted[$file['type']]) {
					$result['errors'][] = __("L'image {0} n'a pas un format accepté ({1}) : uniquement JPEG.",$file['name'],$file['type']);
					return $result;
				} else {
					list($widthSrc,$heightSrc) = getimagesize($file['tmp_name']);
					if ((($widthSrc / $heightSrc) > 1.8) or (($heightSrc / $widthSrc )) > 1.8) {
						$result['errors'][] = __("{0} est trop en largeur ou trop en hauteur : {1}px / {2}px. Veuillez choisir une image avec des proportions standard.",$file['name'],$widthSrc,$heightSrc);
						return $result;
					}
				}
			}
		}

		// Second pass : loop through and deal with the files
		foreach($formdata as $file) {
			if ($file['name'] != "") {
				// transform file name
				$filename = goodFileName($file['name']);
				// switch based on error code
				switch($file['error']) {
					case 0:
						// create unique filename and upload file
						$now = time();
						$full_url = $folder_url.'/'.$now."-".$filename;
						$url = $rel_url.'/'.$now."-".$filename;
						$success = move_uploaded_file($file['tmp_name'], $url);
						$this->resizeImage($full_url,800);
						// if upload was successful
						if($success) {
							// save the url of the file
							$result['urls'][] = $url;
						} else {
							$result['errors'][] = "Error uploaded $filename. Please try again.";
						}
						break;
					case 3:
						// an error occured
						$result['errors'][] = "Error uploading $filename. Please try again.";
						break;
					default:
						// an error occured
						$result['errors'][] = "System error uploading $filename. Contact webmaster.";
						break;
				}
			}
		}
		return $result;
	}
		
	public function resizeImage($rootFileName,$maxLongSize=800) {
		// Get orientation
		$deg = 0;
		if (function_exists('exif_read_data')) {
			$exif = exif_read_data($rootFileName);
			if ($exif and isset($exif['Orientation'])) {
		  		$orientation = $exif['Orientation'];
		  		if ($orientation != 1) {
					switch ($orientation) {
						case 3: 
							$deg = 180; 
							break;
						case 6: 
							$deg = 270; 
							break;
						case 8: 
							$deg = 90; 
							break;
					}
				}
			}
		}
		// Current size
		list($widthSrc,$heightSrc) = getimagesize($rootFileName);
		if (($widthSrc > $maxLongSize) or ($heightSrc > $maxLongSize)) {
			// Image too big : resize it
			if ($widthSrc > $heightSrc) {
				// Landscape
				$widthNew = $maxLongSize;
				$heightNew = round($heightSrc * $maxLongSize / $widthSrc);
			} else {
				// Portrait
				$heightNew = $maxLongSize;
				$widthNew = round($widthSrc * $maxLongSize / $heightSrc);
			}
		} else {
			// Not too big but copy to clean the file (virus)
			$heightNew = $heightSrc;
			$widthNew = $widthSrc;
		}
		$imgObj = imagecreatefromjpeg($rootFileName) or die ("Error imagecreatefromjpeg from ".$rootFileName);
		$imgResized = imagecreatetruecolor($widthNew,$heightNew) or die ("Error imagecreatetruecolor");
		if (!imagecopyresampled($imgResized,$imgObj,0,0,0,0,$widthNew,$heightNew,$widthSrc,$heightSrc)) die ("Error imagecopyreresampled");
		if ($deg) {
			$imgResized = imagerotate($imgResized, $deg, 0);
		}
		if (!imagejpeg($imgResized,$rootFileName,100)) die ("Error imagejpeg");
		return true;
	}
	
	function correctImageOrientation($filename) {
	  if (function_exists('exif_read_data')) {
		$exif = exif_read_data($filename);
		if($exif && isset($exif['Orientation'])) {
		  $orientation = $exif['Orientation'];
		  if($orientation != 1){
			$img = imagecreatefromjpeg($filename);
			$deg = 0;
			switch ($orientation) {
			  case 3:
				$deg = 180;
				break;
			  case 6:
				$deg = 270;
				break;
			  case 8:
				$deg = 90;
				break;
			}
			if ($deg) {
			  $img = imagerotate($img, $deg, 0);        
			}
			// then rewrite the rotated image back to the disk as $filename 
			imagejpeg($img, $filename, 95);
		  } // if there is some rotation necessary
		} // if have the exif orientation info
	  } // if function exists      
	}

	/*
		Fournir la liste des adresses email des administrateurs sous la forme email => alias.
	*/
	public function getAdminEmails() {
		$users = TableRegistry::get('Users');
		$adminUsers = $users->find()->where(['role'=>"admin"]);
		$adminEmails = array();
		foreach ($adminUsers as $adminUser) {
			$adminEmails[$adminUser->username] = $adminUser->alias;
		}
		return $adminEmails;
	}
	
	/*
		Cet email est-il sur liste noire ?
	*/
	public function isBlacklisted($email) {
		$users = TableRegistry::get('Users');
		$count = $users->find('all',['conditions'=>["status IS NOT NULL","status NOT LIKE 'waitForConfirm%'"]])->where(['username'=>$email])->count();
		if ($count == 0) {
			return false;
		} else {
			return true;
		}
	}
	
}
