Ext.define('App.Main', {
	
	singleton: true,
	
	requires: [
		'App.Grid'
	],
	
	init: function() {
		App.Grid.getInstance();
	},
	
});

//# sourceURL=/app/Main.js
