/**
 * @class App.Grid
 * @extends Ext.grid.Panel
 */
Ext.define('App.Grid', {
	
	extend: 'Ext.grid.Panel',
	
	requires: [
		'App.LogModel'
	],
	
	statics: {
		
		/**
		 * @property {App.Grid} grid
		 * @static
		 * @private
		 */
		
		/**
		 * @method
		 * @static
		 *
		 * Получение экземпляра App.Grid
		 *
		 * @return {App.Grid}
		 */
		getInstance: function() {
			if (!this.grid) {
				this.grid = Ext.create('App.Grid');
			}
			return this.grid;
		}
		
	},
	
	/**
	 * @method
	 *
	 * Конструктор класса
	 *
	 * @param {Object} cfg
	 */
	constructor: function(cfg) {
		var config = {
			renderTo: Ext.getBody(),
			store: this.getStore(),
			columns: {
				items: [
					{text: 'IP', dataIndex: 'ip'},
					{text: 'Браузер', dataIndex: 'browser'},
					{text: 'ОС', dataIndex: 'os'},
					{text: 'Источник', dataIndex: 'source', sortable: false},
					{text: 'Назначение', dataIndex: 'destination', sortable: false},
					{text: 'Число страниц', dataIndex: 'count', sortable: false}
				]
			}
		};
		var i;
		for ( i in cfg ) { if ( cfg.hasOwnProperty(i) ) {
			config[i] = cfg[i];
		} }
		this.callParent([config]);
	},
	
	/**
	 * @property {Ext.data.Store} store
	 * @private
	 */
	
	/**
	 * @method
	 *
	 * Получение хранилища данных
	 *
	 * @return {Ext.data.Store}
	 */
	getStore: function() {
		if (!this.store) {
			this.store = Ext.create('Ext.data.Store', {
				model: 'App.LogModel',
				proxy: this.getProxy(),
				autoLoad: true
			});
		}
		return this.store;
	},
	
	/**
	 * @property {Ext.data.proxy.Ajax} proxy
	 * @private
	 */
	
	/**
	 * @method
	 * @return {Ext.data.proxy.Ajax}
	 */
	getProxy: function() {
		if (!this.proxy) {
			this.proxy = Ext.create('Ext.data.proxy.Ajax', {
				url: '/server.php',
				model: 'App.LogModel',
				reader: {
					type: 'json',
					root: 'data',
				}
			});
		}
		return this.proxy;
	},
	
});

//# sourceURL=/app/Grid.js
