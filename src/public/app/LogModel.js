/**
 * @class App.LogModel
 * @extends Ext.data.Model
 *
 * Модель данных получаемых с сервера
 *
 * * ip
 * * source
 * * destination
 * * count
 * * browser
 * * os
 */
Ext.define('App.LogModel', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'ip', type: 'string'},
		{name: 'source', type: 'string'},
		{name: 'destination', type: 'string'},
		{name: 'count', type: 'number'},
		{name: 'browser', type: 'string'},
		{name: 'os', type: 'string'}
	]
});
