<?php
/**
 * Plugin activation
 *
 * Description
 *
 * @package  Croogo
 * @author Juraj Jancuska <jjancuska@gmail.com>
 */
class EshopActivation {
        
        /**
         * Schema directory
         *
         * @var string
         */
        private $SchemaDir;

        /**
         * DB connection
         *
         * @var object
         */
        private $db;

        /**
         * Constructor
         *
         * @return vodi
         */
         public function  __construct() {

                 $this->SchemaDir = APP.'plugins'.DS.'eshop'.DS.'config'.DS.'schemas';
                 $this->db =& ConnectionManager::getDataSource('default');

        }

        /**
         * Before onActivation
         *
         * @param object $controller
         * @return boolean
         */
        public function beforeActivation(&$controller) {

                App::Import('CakeSchema');
                $CakeSchema = new CakeSchema();

                // list schema files from config/schema dir
                if (!$cake_schema_files = $this->_listSchemas($this->SchemaDir))
                        return false;

                // create table for each schema
                foreach ($cake_schema_files as $schema_file) {
                        $schema_name = substr($schema_file, 0, -4);
                        $schema_class_name = Inflector::camelize($schema_name).'Schema';
                        $table_name = $schema_name;

                        if (!in_array($table_name, $this->db->_sources)) {
                                 include_once($this->SchemaDir.DS.$schema_file);
                                 $ActiveSchema = new $schema_class_name;
                                 if(!$this->db->execute($this->db->createSchema($ActiveSchema, $table_name))) {
                                         return false;
                                 }
                        }

                }

                // check if exist node type product, if not create 'product' type
                $Type = ClassRegistry::init('Type');
                if (!$Type->findByAlias('product')) {
                        $Type->create();
                        $data['Type'] = array(
                            'title' => 'Eshop product',
                            'alias' => 'product',
                            'description' => 'Type for products of Eshop plugin',
                            'format_show_author' => 0,
                            'format_show_date' => 0,
                            'comment_status' => 0,
                            'comment_approve' => 0,
                            'comment_spam_protection' => 0,
                            'comment_captcha' => 0,
                            'plugin' => 'eshop'
                        );
                        if(!$Type->save($data)) {
                                return false;
                        }
                }

                return true;

        }

        /**
         * Activation of plugin,
         * called only if beforeActivation return true
         *
         * @param object $controller
         * @return void
         */
        public function onActivation(&$controller) {
                $controller->Croogo->addAco('EshopItems');
                $controller->Croogo->addAco('EshopItems/admin_index');
                $controller->Croogo->addAco('EshopItems/admin_add');
                $controller->Croogo->addAco('EshopItems/admin_edit');
                $controller->Croogo->addAco('EshopItems/admin_delete');
                $controller->Croogo->addAco('EshopSuppliers');
                $controller->Croogo->addAco('EshopSuppliers/admin_index');
                $controller->Croogo->addAco('EshopSuppliers/admin_add');
                $controller->Croogo->addAco('EshopSuppliers/admin_edit');
                $controller->Croogo->addAco('EshopSuppliers/admin_delete');

        }

        /**
         * Before onDeactivation
         *
         * @param object $controller
         * @return boolean
         */
        public function beforeDeactivation(&$controller) {

                // list schema files from config/schema dir
                if (!$cake_schema_files = $this->_listSchemas($this->SchemaDir))
                        return false;

                // delete tables for each schema
                foreach ($cake_schema_files as $schema_file) {
                        $schema_name = substr($schema_file, 0, -4);
                        $table_name = $schema_name;
                        if(!$this->db->execute('DROP TABLE '.$table_name)) {
                                return false;
                        }
                }
                return true;

        }

        /**
         * Deactivation of plugin,
         * called only if beforeActivation return true
         *
         * @param object $controller
         * @return void
         */
        public function onDeactivation(&$controller) {
                $controller->Croogo->removeAco('EshopItems');
                $controller->Croogo->removeAco('EshopSuppliers');
        }

        /**
         * List schemas
         *
         * @return array
         */
        private function _listSchemas($dir = false) {

                if (!$dir) return false;

                $cake_schema_files = array();
                if ($h = opendir($dir)) {
                        while (false !== ($file = readdir($h))) {
                                if (($file != ".") && ($file != "..")) {
                                        $cake_schema_files[] = $file;
                                }
                        }
                } else {
                        return false;
                }

                return $cake_schema_files;

        }
}
?>