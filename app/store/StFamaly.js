/*
 * File: app/store/StFamaly.js
 * Date: Sun May 03 2020 23:02:11 GMT+0300 (EEST)
 *
 * This file was generated by Sencha Architect version 3.2.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 5.1.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 5.1.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('yis.store.StFamaly', {
    extend: 'Ext.data.Store',
    alias: 'store.StFamaly',

    requires: [
        'yis.model.MdAppartment',
        'Ext.data.proxy.Direct',
        'yis.DirectAPI',
        'Ext.data.reader.Json',
        'Ext.data.writer.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'StFamaly',
            model: 'yis.model.MdAppartment',
            proxy: {
                type: 'direct',
                directFn: 'QueryAddress.getResults',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                },
                writer: {
                    type: 'json',
                    writeAllFields: true
                }
            }
        }, cfg)]);
    }
});