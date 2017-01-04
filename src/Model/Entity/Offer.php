<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Offer Entity
 *
 * @property int $id
 * @property string $title
 * @property int $subcategory_id
 * @property string $subtitle
 * @property $photo
 * @property string $dir
 * @property string $description
 * @property string $email
 * @property string $phone
 * @property string $facetime_phone
 * @property string $urls
 * @property bool $is_expired
 *
 * @property \App\Model\Entity\Subcategory $subcategory
 */
class Offer extends Entity
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
        'id' => false,
        'photos' => true
    ];
}
