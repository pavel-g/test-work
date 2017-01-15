Ext.onReady(function() {
	Ext.Loader.setPath('App', '/app');
	Ext.Loader.require([
		'App.Main'
	], function() {
		App.Main.init();
	});
});
