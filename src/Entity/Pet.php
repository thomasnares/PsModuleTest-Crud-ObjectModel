<?php
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0).
 * It is also available through the world-wide-web at this URL: https://opensource.org/licenses/AFL-3.0
 */

namespace Preston\CustomerPetList\Entity;

use PrestaShop\PrestaShop\Adapter\Entity\ObjectModel;

/**
 * This entity database state is managed by PrestaShop ObjectModel
 */
class Pet extends ObjectModel
{
    /**
     * @var int
     */
    public $id_customer;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $breed;

    public static $definition = [
        'table' => 'custom_pet',
        'primary' => 'id_pet',
        'fields' => [
            'id_customer' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'],
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
            'breed' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
        ],
    ];
}