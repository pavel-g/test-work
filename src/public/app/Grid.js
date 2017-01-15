/**
 * @class App.Grid
 * @extends Ext.grid.Panel
 */
Ext.define('App.Grid', {
	
	extend: 'Ext.grid.Panel',
	
	requires: [
		'App.LogModel'
	],
	
	/**
	 * @method
	 *
	 * Конструктор класса
	 *
	 * @param {Object} cfg
	 */
	constructor: function(cfg) {
		var config = {
			// renderTo: Ext.getBody(),
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
			},
			tbar: [
				this.getIpField(),
				this.getSearchButton()
			]
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
	
	/**
	 * @property {Ext.form.field.Text} ipField
	 * @private
	 */
	
	/**
	 * @method
	 *
	 * Получение поля для фильтрации ip
	 *
	 * @return {Ext.form.field.Text}
	 */
	getIpField: function() {
		if (!this.ipField) {
			this.ipField = Ext.create('Ext.form.field.Text', {
				width: 150
			});
		}
		return this.ipField;
	},
	
	/**
	 * @property {Ext.button.Button} searchButton
	 * @private
	 */
	
	/**
	 * @method
	 *
	 * Получение кнопки "Поиск"
	 *
	 * @return {Ext.button.Button}
	 */
	getSearchButton: function() {
		if (!this.searchButton) {
			this.searchButton = Ext.create('Ext.button.Button', {
				text: 'Поиск'
			});
		}
		return this.searchButton;
	},
	
});

//# sourceURL=/app/Grid.js
