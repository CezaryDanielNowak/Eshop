<?php
/**
 * Plugin activation
 *
 * Description
 *
 * @package  Croogo
 * @author Juraj Jancuska <jjancuska@gmail.com>
 */

App::uses('CakeSchema', 'Model');
 
class EshopActivation {

        /**
         * Before onActivation
         *
         * @param object $controller
         * @return boolean
         */
        public function beforeActivation(&$controller) {
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
						$schema = & new CakeSchema(array(
									'name' => 'Eshop',
									'path' => APP . 'Plugin' . DS . 'Eshop' . DS . 'Config' . DS . 'schema',
										)
						);
						$schema = $schema->load();
                // set Aco
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
                $controller->Croogo->addAco('EshopBasket');
                $controller->Croogo->addAco('EshopBasket/add', array('registered', 'public'));
                $controller->Croogo->addAco('EshopBasket/view', array('registered', 'public'));
                $controller->Croogo->addAco('EshopBasket/delete', array('registered', 'public'));
                $controller->Croogo->addAco('EshopBasket/recalc', array('registered', 'public'));
                $controller->Croogo->addAco('EshopBasket/basketSummary', array('registered', 'public'));
                $controller->Croogo->addAco('EshopOrders');
                $controller->Croogo->addAco('EshopOrders/admin_index');
                $controller->Croogo->addAco('EshopOrders/add', array('registered', 'public'));

                // set default config
                $statuses = 'Waiting for acceptacion,Accepted,Canceled,Sended,Delivered,Rejected';
                $payement = 'Cash on delivery,Proforma invoice,Personally';
                $shipping = 'Cash on delivery,Curier,Personally';
                $vat = 20;

                $controller->Setting->write('Eshop.statuses', $statuses, array(
                    'editable' => 1, 'description' => __('Types of order statuses', true))
                );
                $controller->Setting->write('Eshop.payement', $payement, array(
                    'editable' => 1, 'description' => __('Types of payement method', true))
                );
                $controller->Setting->write('Eshop.shipping', $shipping, array(
                    'editable' => 1, 'description' => __('Shiping methods', true))
                );
                $controller->Setting->write('Eshop.email', Configure::read('Site.email'), array(
                    'editable' => 1, 'description' => __('All orders will be sended to orderer email and to this email also', true))
                );
                $controller->Setting->write('Eshop.vat', $vat, array(
                    'editable' => 1, 'description' => __('Default VAT',true))
                );

                // create basket summary block
                if (!$controller->Blocks->Block->save(array(
                        'region_id' => 4,
                        'title' => 'Eshop basket summary',
                        'alias' => 'eshopbasketsummary',
                        'body' => '[element:basket_summary plugin="Eshop"]',
                        'show_title' => 1,
                        'status' => 1
                        ))) return false;

                // create product type if not exists
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

        }

        /**
         * Before onDeactivation
         *
         * @param object $controller
         * @return boolean
         */
        public function beforeDeactivation(&$controller) {
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

                // remove accos
                $controller->Croogo->removeAco('EshopItems');
                $controller->Croogo->removeAco('EshopSuppliers');
                $controller->Croogo->removeAco('EshopBasket');
                $controller->Croogo->removeAco('EshopOrders');

                // remove eshop basket summary block
								$controller->Blocks->Block->deleteAll(array('Block.alias' => "eshopbasketsummary"));
        }

}
?>