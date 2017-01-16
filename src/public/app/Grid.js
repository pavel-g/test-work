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
					{text: 'IP', dataIndex: 'ip', flex: 2},
					{text: 'Браузер', dataIndex: 'browser', flex: 2},
					{text: 'ОС', dataIndex: 'os', flex: 2},
					{text: 'Источник', dataIndex: 'source', sortable: false, flex: 2},
					{text: 'Назначение', dataIndex: 'destination', sortable: false, flex: 2},
					{text: 'Число страниц', dataIndex: 'count', sortable: false, flex: 1}
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
			var me = this;
			this.ipField = Ext.create('Ext.form.field.Text', {
				width: 150,
				validator: function(value) {
					if (typeof value === 'string' && value.length === 0) return true;
					var res = me.checkIp(value);
					return res === true ? res : 'Неверный ip';
				},
				emptyText: 'IP адрес'
			});
		}
		return this.ipField;
	},
	
	/**
	 * @property {RegExp}
	 * @protected
	 */
	regexpCheckNum: new RegExp("^\\d+$"),
	
	/**
	 * @method
	 * @protected
	 *
	 * Проверка записи в строке целого числа
	 *
	 * @param {String} str
	 * @return {Boolean}
	 */
	checkInteger: function(str) {
		return Boolean(this.regexpCheckNum.test(str));
	},
	
	/**
	 * @method
	 * @protected
	 *
	 * Проверка ip адреса
	 *
	 * @param {String} ip
	 * @return {Boolean}
	 */
	checkIp: function(ip) {
		var MIN_IP = 0;
		var MAX_IP = 255;
		if (typeof ip !== 'string') return false;
		var parts = ip.split('.');
		if (parts.length >= 5) return false;
		var i, part, num;
		for ( i = 0; i < parts.length; i++ ) {
			part = parts[i];
			if (typeof part === 'string' && part.length === 0 && (i === 0 || i === parts.length - 1)) {
				continue;
			}
			if (!this.checkInteger(part)) return false;
			num = Number(part);
			if (num < MIN_IP || num > MAX_IP) return false;
		}
		return true;
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
			var me = this;
			this.searchButton = Ext.create('Ext.button.Button', {
				text: 'Поиск',
				handler: function() {
					var field = me.getIpField();
					if (!field.validate()) return;
					var value = field.getValue();
					var operation;
					if (value.length > 0) {
						operation = Ext.create('Ext.data.Operation', {
							action: 'read',
							filters: [
								Ext.create('Ext.util.Filter', {
									property: 'ip',
									value: value
								})
							]
						});
					} else {
						operation = Ext.create('Ext.data.Operation', {
							action: 'read'
						});
					}
					var proxy = me.getProxy();
					proxy.read(operation, function(operation) {
						// TODO: Как-то настроить ExtJS на самостоятельное обновление данных
						me.getStore().loadData(operation.getResultSet().records);
					});
				}
			});
		}
		return this.searchButton;
	},
	
});

//# sourceURL=/app/Grid.js
