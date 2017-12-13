<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\View\Helper\SessionHelper;

class Stats extends Entity
{

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
	
}
