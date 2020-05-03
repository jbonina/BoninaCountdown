<?php

use BoninaCountdown\Components\Countdown as CountdownClass;
 
class Shopware_Controllers_Frontend_Countdown extends \Enlight_Controller_Action
{
    public function indexAction()
    {
		$countdown = new CountdownClass;
		$remainingTime = $countdown->getCountdown();
		
		$config = $this->container->get('shopware.plugin.config_reader')->getByPluginName('BoninaCountdown');
		$countdownEnde = $config['countdownEndeServer'];
		$active = $config['aktiv'];	
		
		$this->Front()->Plugins()->ViewRenderer()->setNoRender(); // Wichtig!!!!!!!
		$this->Response()->setHeader('Content-type', 'application/json', true);
        $this->Response()->setBody(json_encode(array('success' => true, 
													'remainingTime' => $remainingTime, 
													'active' => $config['aktiv'])));
    }
}