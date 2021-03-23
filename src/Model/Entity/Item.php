<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property string $state
 * @property int $category_id
 * @property string $image_1_url
 * @property string $image_2_url
 * @property string $image_3_url
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\User $user
 */
class Item extends Entity
{

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
	
	public function isDonate() {
		return ($this->type == "d");
	}
	
	public function isSearch() {
		return ($this->type == "r");
	}
	
	public function isBooked() {
		return ($this->status == 1 or $this->status == 3);
	}
	
	protected function _getBooked() {
		return ($this->status == 1 or $this->status == 3);
	}
	
	public function book($book) {
		if ($book) {
			if (!$this->isBooked()) {
				$this->status += 1;
			}
		} elseif ($this->isBooked()) {
			$this->status -=1;
		}
	}
}
