Ext.define('App.Main', {
	
	singleton: true,
	
	requires: [
		'App.Viewport'
	],
	
	init: function() {
		App.Viewport.getInstance();
	},
	
});

//# sourceURL=/app/Main.js
