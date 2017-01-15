/**
 * @class App.LogModel
 * @extends Ext.data.Model
 *
 * Модель данных получаемых с сервера
 *
 * * time
 * * ip
 * * browser
 * * os
 * * source
 * * destination
 */
Ext.define('App.LogModel', {
	extend: 'Ext.data.Model',
	fields: ['time', 'ip', 'browser', 'os', 'source', 'destination']
});
