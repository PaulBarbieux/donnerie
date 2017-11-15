<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $title_fr
 * @property string $title_nl
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Item[] $items
 */
class Street extends Entity
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
		Nom dans la bonne langue. Renvoie l'autre langue si la langue visée est vide (on suppose qu'au moins une des deux langues est remplies).
	*/
	protected function _getName()
    {
		if ($this->_properties['name_'.LG] != "") {
			return $this->_properties['name_'.LG];
		} else {
			return (LG == "fr" ? $this->_properties['name_nl'] : $this->_properties['name_fr']);
		}
    }
}
