<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\View\Helper\SessionHelper;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $title_fr
 * @property string $description_fr
 * @property string $title_nl
 * @property string $description_nl
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Item[] $items
 */
class Category extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
	
	/*
		Titre dans la bonne langue : renvoie l'autre langue si la langue visée est vide (on suppose qu'au moins une des deux langues est remplies).
	*/
	protected function _getTitle()
    {
		if ($this->_properties['title_'.LG] != "") {
			return $this->_properties['title_'.LG];
		} else {
			return (LG == "fr" ? $this->_properties['title_nl'] : $this->_properties['title_fr']);
		}
    }
	/*
		Description dans la bonne langue
	*/
	protected function _getDescription()
    {
		if ($this->_properties['description_'.LG] != "") {
			return $this->_properties['description_'.LG];
		} else {
			return (LG == "fr" ? $this->_properties['description_nl'] : $this->_properties['description_fr']);
		}
    }
}
