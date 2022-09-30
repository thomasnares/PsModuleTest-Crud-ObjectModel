<?php

declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

// Needed for install process
require_once __DIR__ . '/vendor/autoload.php';

use Preston\CustomerPetList\Controller\Admin\PetController;

class CustomerPetList extends Module
{

    const INSTALL_SQL_FILE = 'install.sql';
    const UNINSTALL_SQL_FILE = 'uninstall.sql';

    public function __construct()
    {
        $this->name = 'customerpetlist';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Thomas NARES';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6.0',
            'max' => '8.1.0',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Customer Pet List');
        $this->description = $this->l('This module allows you to store the Pet list of a Customer');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall and delete all pets from database ?');

        // See https://devdocs.prestashop.com/1.7/modules/concepts/controllers/admin-controllers/tabs/
        $tabNames = [];
        foreach (Language::getLanguages(true) as $lang) {
            $tabNames[$lang['locale']] = 'Pet list';
        }
        $this->tabs = [
            [
                'route_name' => 'preston_customerpetlist_controller_index',
                'class_name' => PetController::TAB_CLASS_NAME,
                'visible' => true,
                'name' => $tabNames,
                'icon' => 'school',
                'parent_class_name' => 'IMPROVE',
            ],
        ];

    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!file_exists(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE)) {
            return false;
        } elseif (!$sql = file_get_contents(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE)) {
            return false;
        }
        
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
        foreach ($sql as $query) {
            if (!Db::getInstance()->execute(trim($query))) {
                return false;
            }
        }

        return (
            parent::install() 
        ); 
    }
    
    public function uninstall()
    {
        if (!file_exists(dirname(__FILE__) . '/' . self::UNINSTALL_SQL_FILE)) {
            return false;
        } elseif (!$sql = file_get_contents(dirname(__FILE__) . '/' . self::UNINSTALL_SQL_FILE)) {
            return false;
        }

        $sql = str_replace(['ENGINE_TYPE'], [_MYSQL_ENGINE_], $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
        foreach ($sql as $query) {
            if (!Db::getInstance()->execute(trim($query))) {
                return false;
            }
        }

        return (
            parent::uninstall()
        );
    }

}
