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

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		
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
			'authError' => __("Veuillez vous connecter pour pouvoir faire cette action")
        ]);
		$this->Auth->allow(['changeLanguage', 'contact']);
		
		/*
			Language
		*/
		if ($this->request->session()->check('Config.language')) {
			I18n::locale($this->request->session()->read('Config.language'));
			define('LG',substr($this->request->session()->read('Config.language'),0,2));
        } else {
			I18n::locale("fr_FR");
			define('LG','fr');
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
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
	
	public function isAuthorized($user = null) {
		return true;
	}
	
	public function changeLanguage($language) {
		$this->request->session()->write('Config.language', $language);
		$this->redirect($this->referer());
	}
	
	public function contact() {
        if ($this->request->is('post')) {
			$data = $this->request->getData();
			if (!isset($data['email'])) {
				$data['email'] = $this->Auth->user('username');
				$data['name'] = $this->Auth->user('alias');
			}
			$data['message'] = strip_tags(trim($data['message']));
			$data['url'] = $this->referer();
			if ($this->request->session()->read('Config.language') == "nl_NL") {
				$template = "contact_nl";
			} else {
				$template = "contact_fr";
			}
			$email = new Email();
			$email->replyTo([$data['email'] => $data['name']])
				->setTemplate($template)
				->viewVars([
					'email' => $data['email'], 
					'name' => $data['name'], 
					'url' => $data['url'], 
					'message' => nl2br($data['message'])])
				->to(EMAIL_ADMIN)
				->subject("Donnerie : message de ".$data['name'])
				->send();
			$this->Flash->success(__("Votre message a été envoyé. Merci."));
			$this->redirect($this->referer());
		}
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
		
		// list of permitted file types, this is only images but documents can be added
		$permitted = array('image/gif'=>true,'image/jpeg'=>true,'image/pjpeg'=>true,'image/png'=>true);
		
		// First pass : loop through and check file size and types
		foreach($formdata as $file) {
			if ($file['name'] != "") {
				if ($file['error'] == 1) {
					$result['errors'][] = __("{0} est trop grande. Choisissez une autre image ou réduisez celle-ci avec un programme d'image.",$file['name']);
					return $result;
				} elseif (!isset($permitted[$file['type']])) {
					$result['errors'][] = __("{0} ({1}) n'est pas un format accepté : gif, jpg, png.",$file['name'],$file['type']);
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
				$filename = str_replace(' ', '_', $file['name']);
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
		// Current size
		list($widthSrc,$heightSrc) = getimagesize($rootFileName);
		if (($widthSrc > $maxLongSize) or ($heightSrc > $maxLongSize)) {
			if ($widthSrc > $heightSrc) {
				// Landscape
				$widthNew = $maxLongSize;
				$heightNew = round($heightSrc * $maxLongSize / $widthSrc);
			} else {
				// Portrait
				$heightNew = $maxLongSize;
				$widthNew = round($widthSrc * $maxLongSize / $heightSrc);
			}
			$imgObj = imagecreatefromjpeg($rootFileName) or die ("Error imagecreatefromjpeg from ".$rootFileName);
			$imgResized = imagecreatetruecolor($widthNew,$heightNew) or die ("Error imagecreatetruecolor");
			if (!imagecopyresampled($imgResized,$imgObj,0,0,0,0,$widthNew,$heightNew,$widthSrc,$heightSrc)) die ("Error imagecopyreresampled");
			if (!imagejpeg($imgResized,$rootFileName,100)) die ("Error imagejpeg");
		}
		return true;
	}

	
}
