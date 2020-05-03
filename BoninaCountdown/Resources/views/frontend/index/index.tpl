{extends file="parent:frontend/index/index.tpl"}

{block name="frontend_index_navigation_categories_top_include"}

    <style>
        .countdown-box {
            width:100%;
            text-align:center;
        }
        .countdown-timer {
            font-size:40px;
			font-weight:bold;
			color:{if $hinweistextFarbe == '' || $hinweistextFarbe == '#'}#FF6600{else}{$hinweistextFarbe}{/if};	
        }
    </style>


    <div class="countdown-box">
		<span id="hinweistext" class="countdown-timer">{$hinweistext}</span>
		<!-- <span class="countdown-timer">{$minuten}</span>
        <span class="countdown-timer">{$sekunden}</span>
		<span class="countdown-timer">{$auswahl}</span>		-->
		<div id="dvData" class="countdown-timer"></div>
		<div data-my-component="true" class="plugin-example" id="plugin-example">123</div>
    </div>
    
    {$smarty.block.parent}
{/block}