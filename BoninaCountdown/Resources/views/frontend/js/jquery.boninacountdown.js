/**
 * Example jQuery plugin using the base class
 *
 * The $.plugin method bound to the globally available jQuery
 * object. The method needs two parameters, the first one is
 * simply the name of the plugin which will be used to bind
 * the plugin to jQuery's $.fn namespace. The second parameter
 * is an object which provides the default configuration and 
 * the actual implementation of the plugin.
 */
$.plugin('boninaCountdown', {
    
    /**
     * The default configuration object of the plugin. The
     * user can provide custom settings which will be automatically
     * merged into a new object which can be accessed using "this.opts"
     * in any plugin method which scope is in the plugin.
     */
    defaults: {
        activeCls: 'js--is-active'
    },
    
    /**
     * The "init" method acts like a constructor for the plugin.
     * Usually you'll cache necessary elements and registers the
     * event listeners for your plugin. Additionally you can switch
     * up the behavior of the plugin based on the provided configuration.
     */
    init: function() {
        var me = this;
		var controllerURL = 'http://192.168.33.10/shopware/frontend/Countdown';		
		var intervalfn;
        
		alert(controllerURL);
        /**
         * Calling the "applyDataAttributes" method the base class
         * automatically reads out the all "data" attributes from
         * the element and overrides the configuration. It's especially
         * useful if you want to configure your plugin using HTML
         * markup instead of providing a configuration object.
         *
         * For example, we call this plugin on the following element:
         *    <div data-activeCls="some-other-class">...</div>
         *
         * ... the "data" attribute will override the "activeCls"
         * property with the value "some-other-class".
         */
        me.applyDataAttributes();
        
        /**
         * Now we're setting up a new event listener for the plugin
         * using the built-in "_on" method which is actually a proxy
         * method for jQuery's "on" method with some additional benefits.
         * The event listener and the event will be registered in a
         * plugin specific event collection. The collection will be 
         * automatically iterated and removes the registered event listeners
         * from the element.
         * Additionally, the event name will be namespaced on the fly which
         * provides us with a safe way to remove a specific event listener from
         * an element and doesn't affect other plugins which are listening on
         * the same event. 
         */
        /*me._on(me.$el, 'click', function(event) {
            event.preventDefault();*/
            
            /**
             * In the condition we're using the custom expression of the plugin
             * to terminate if the element uses our plugin.
             * Additionally you see that we're using the variable "this.$el" which
             * is the element that has instanciated the plugin.
             */
            //if(me.$el.is('container-boninaCountdown')) {
              //  alert(me.controllerURL);
                /**
                 * Now we're accessing the merged configuration of the plugin using
                 * the variable "this.opts".
                 */
                //me.$el.toggleClass(me.opts.activeCls);
            }		
        //}
		//);
		me.check();
    },
	
	paddZero: function (num) {
		if (num < 10) {
			num = "0" + num;
		}
		return num;
	},
	
	countdown: function(ende) {
		var me = this;
		var verbleibend = ende - Date.now();
		var sekunden = verbleibend / 1000;
		var minutes = Math.floor(sekunden / 60);
		var sekunden = Math.floor(sekunden % 60);	
		if (verbleibend <= 0) {
			clearInterval(me.intervalfn);
			$('#dvData').html(" ");
			$('#dvData').css('visibility', 'hidden');
			$('#hinweistext').css('visibility', 'hidden');				
		} 
		else {
			$('#dvData').html(me.paddZero(minutes) + ":" + me.paddZero(sekunden));				
		}
	},
	
	startCountDown: function(remainingCountdown) {
		var me = this;
		var jetzt = Date.now(); // milisekunden
		var ende = jetzt + remainingCountdown;					 				
		me.intervalfn = setInterval(function(){ 
			me.countdown(ende)}
		, 100); 
	},
	
	check: function() {
		var me = this;
		alert('Checking...');
		$.ajax({
			url: me.controllerURL,
			type: "GET",
			dataType: "application/json; charset=utf-8",
			success: function (data) {
				var response = $(JSON.parse(data));
				if (response.active) {
					if (response.remainingTime == 0) {
						$('#dvData').html("Countdown ended,");			
					} else {
						me.startCountdown(response.remainingTime);
					}
				}
			}
		});	
	},
	
    
    /**
     * The destroy method can either be called programmically from outside the plugin
     * or automatically using the "StateManager" when the defined states are left.
     * Usually, you remove classes which were added by your plugin to the element and
     * removes the event listeners from the element.
     */
    destroy: function() {
        var me = this;
    
        me.$el.removeClass(me.opts.activeCls);
        
        /**
         * Calling the "_destroy" method will remove all event listeners which were
         * registered using the "_on" method of the plugin base.
         * You can access the collection of the events in the plugin using the variable
         * "this._events" if you want to iterate over the event listeners yourself.
         */
        me._destroy();
    }
});

StateManager.addPlugin('[data-my-component="true"]', 'boninaCountdown', [ 'xs', 's' , 'm', 'l', 'xl']);

