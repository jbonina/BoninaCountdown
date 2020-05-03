<?php
 
namespace BoninaCountdown;

use Shopware\Components\Plugin;
/*use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Shopware\Bundle\AttributeBundle\Service\TypeMapping;*/

class BoninaCountdown extends Plugin
{
	/*public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
    }*/
	
	public static function getSubscribedEvents()
    {
        return [
            //'Enlight_Controller_Dispatcher_ControllerPath_Api_Countdown' => 'onGetCountdownApiController',
            //'Enlight_Controller_Front_StartDispatch' => 'onEnlightControllerFrontStartDispatch'
			//'Enlight_Controller_Dispatcher_ControllerPath_Api_Countdown' => 'onGetCountdownApiController',
        ];
    }
	
	
	/*public function onGetCountdownApiController()
    {
        return $this->getPath() . '/Controllers/Api/Countdown.php';
    }*/

    /*public function onEnlightControllerFrontStartDispatch()
    {
        //$this->container->get('loader')->registerNamespace('Shopware\Components', $this->getPath() . '/Components/');
    }*/
	
	/*private function createControllers(){
//        There we register our own controller
        $this->registerController('Frontend', 'Example');

        return $this;
    }*/

	/*
	public function install() {
		$this->registerController('Frontend', 'Countdown');
	}

	 public function uninstall(UninstallContext $uninstallContext)
	 {
		 // If the user wants to keep his data we will not delete it while uninstalling the plugin
		 if ($uninstallContext->keepUserData()) {
			 return;
		 }

		 $attributeCrudService = $this->container->get('shopware_attribute.crud_service');

		 $attributeCrudService->delete('s_core_config_elements', 'countdown_end');

		 // clear cache
		 $uninstallContext->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);
	 }

	 public function update(UpdateContext $updateContext)
	 {
		 $currentVersion = $updateContext->getCurrentVersion();
		 $updateVersion = $updateContext->getUpdateVersion();

		 if (version_compare($currentVersion, '1.0.0', '<=')) {
			
		 }

		 if (version_compare($currentVersion, '1.0.5', '<=')) {
			 // do update for version
		 }
	 }

	 public function activate(ActivateContext $activateContext)
	 {
		 // on plugin activation clear the cache
		 $activateContext->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);         
	 }

	 public function deactivate(DeactivateContext $deactivateContext)
	 {
		 // on plugin deactivation clear the cache
		 $deactivateContext->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
	 }*/
}