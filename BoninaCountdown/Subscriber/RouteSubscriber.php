<?php
namespace BoninaCountdown\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\Plugin\ConfigReader;
use BoninaCountdown\Components\Countdown;

class RouteSubscriber implements SubscriberInterface
{
	private $pluginDirectory;
	private $countdown;
	private $config;

	public static function getSubscribedEvents()
	{
		return [
			'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostDispatch',
			'Shopware_CronJob_CountdownToService' => 'onCountdownToServiceCronjob',
			'Theme_Compiler_Collect_Plugin_Javascript' => 'onCollectJsFiles'
		];
   }

	public function __construct($pluginName, $pluginDirectory, Countdown $countdown, ConfigReader $configReader)
	{
		$this->pluginDirectory = $pluginDirectory;
		$this->countdown = $countdown;

		$this->config = $configReader->getByPluginName($pluginName);
	}

	public function onPostDispatch(\Enlight_Controller_ActionEventArgs $args)
	{
		/** @var \Enlight_Controller_Action $controller */
		$controller = $args->get('subject');
		$view = $controller->View();

		$view->addTemplateDir($this->pluginDirectory . '/Resources/views');

		$view->assign('hinweistext', $this->config['hinweistext']);
		$view->assign('minuten', $this->config['minuten']);	   
		$view->assign('sekunden', $this->config['sekunden']);
		$view->assign('auswahl', $this->config['auswahl']);
		$view->assign('ipAdresseFurWartungModus', $this->config['ipAdresseFurWartungModus']);
		$view->assign('hinweistextFarbe', $this->config['hinweistextFarbe']);
		$view->assign('aktiv', $this->config['aktiv']);
		
		$view->assign('countdownEnde', $this->config['countdownEnde']);

		/*if ($this->config['auswahl'] != 0) {
			$this->countdown->sekunden = $this->config['auswahl'];
		} else {
			$this->countdown->sekunden = $this->config['minuten'] * 60 + $this->config['sekunden'];
		}
		
		$view->assign('countdownEnde', $this->config['aktiv']);
	   */
		/*$view->assign('swagSloganContent', $this->config['swagSloganContent']);
   
		if (!$this->config['swagSloganContent']) {
			$view->assign('swagSloganContent', $this->sloganPrinter->getSlogan());
		}*/
	}
   
	private function deactivateCountdownConfig()
	{
		$elementRepository = Shopware()->Models()->getRepository('Shopware\Models\Config\Element');
		$element = $elementRepository->findOneBy(['name' => 'aktiv']);
				
		$element->setValue(0);
		Shopware()->Models()->persist($element);
		
		$values = $element->getValues();
		foreach ($values as $value) {
			$value->setValue(0);
			Shopware()->Models()->persist($value);
		}	
		Shopware()->Models()->flush();
	}
	
	
	private function setElementValue($element, $newValue)
	{
		$element->setValue($newValue);
		Shopware()->Models()->persist($element);
		
		$values = $element->getValues();
		foreach ($values as $value) {
			$value->setValue($newValue);
			Shopware()->Models()->persist($value);
		}
		Shopware()->Models()->flush();
	}	
	
	private function setOfflineFlag($element)
	{
		$this->setElementValue($element, 1);
	}
	
	private function setOfflineIp($element, $newOfflineIp)
	{
		$this->setElementValue($element, $newOfflineIp);
	}
	
	private function startServiceMode()
	{			
		$elementRepository = Shopware()->Models()->getRepository('Shopware\Models\Config\Element');
		$elementOfflineFlag = $elementRepository->findOneBy(['name' => 'setOffline']);
		$this->setOfflineFlag($elementOfflineFlag);
		
		$elementOfflineIp = $elementRepository->findOneBy(['name' => 'offlineIp']);
		$this->setOfflineIp($elementOfflineIp, str_replace(",", " ", $this->config['ipAdresseFurWartungModus']));
		
		$cache = \Shopware\Components\Api\Manager::getResource('cache');
		$cache->delete('all');
	}
	
	public function onCountdownToServiceCronjob(\Shopware_Components_Cron_CronJob $job)
	{
		$this->deactivateCountdownConfig();
		$this->config['aktiv'] = 0;
		$this->startServiceMode();
		
		// wenn der countdown plugin aktiv ist
		//if ($this->config['aktiv'] == '1') {
	
		//}
	}
	
	public function onCollectJsFiles()
    {
        $jsFiles = [
            //$this->pluginDirectory . '/Resources/views/frontend/js/jquery.boninacountdown.js',
			//$this->pluginDirectory . '/Resources/views/frontend/js/jquery.countdown.js',
			$this->pluginDirectory . '/Resources/views/frontend/js/jquery.example.js',
        ];
        return new ArrayCollection($jsFiles);
    }
}