/**
 * @class App.Viewport
 * @extends Ext.container.Viewport
 */
Ext.define('App.Viewport', {
	
	extend: 'Ext.container.Viewport',
	
	requires: [
		'App.Grid'
	],
	
	statics: {
		
		/**
		 * @property {App.Viewport} panel
		 * @private
		 */
		
		/**
		 * @method
		 * @static
		 *
		 * Получение экземпляра App.Viewport
		 *
		 * @return {App.Viewport}
		 */
		getInstance: function() {
			if (!this.panel) {
				this.panel = Ext.create('App.Viewport');
			}
			return this.panel;
		}
		
	},
	
	/**
	 * @method
	 *
	 * Конструктор
	 *
	 * @param {Object} cfg
	 */
	constructor: function(cfg) {
		var config = {
			layout: 'border',
			renderTo: Ext.getBody(),
			items: [
				this.getGridPanel()
			]
		};
		var i;
		for ( i in cfg ) { if ( cfg.hasOwnProperty(i) ) {
			config[i] = cfg[i];
		} }
		this.callParent([config]);
	},
	
	/**
	 * @property {App.Grid} gridPanel
	 * @private
	 */
	
	/**
	 * @method
	 *
	 * Получение таблицы
	 *
	 * @return {App.Grid}
	 */
	getGridPanel: function() {
		if (!this.gridPanel) {
			this.gridPanel = Ext.create('App.Grid');
			this.gridPanel.region = 'center';
		}
		return this.gridPanel;
	},
	
});

//# sourceURL=/app/Viewport.js
