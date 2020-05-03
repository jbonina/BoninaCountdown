<?php

namespace BoninaCountdown\Components;

class Countdown
{
    public function getCountdown()
    {
		$countdown = -1;
		
		$config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('BoninaCountdown');
		$countdownEnde = $config['countdownEndeServer'];
		$active = $config['aktiv'];
		
		$currentMiliseconds = round(microtime(true) * 1000); // current miliseconds
		if ($active == 1)
		{
			if ($countdownEnde > $currentMiliseconds) 
			{
				$countdown = $countdownEnde - $currentMiliseconds;
			} 
			else
			{
				$countdown = 0;
			}				
		}			
		
        return $countdown;
    }
}
