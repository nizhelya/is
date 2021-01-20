/*
 * File: app/store/StRaion.js
 * Date: Thu Sep 24 2020 19:06:08 GMT+0300 (EEST)
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

Ext.define('yis.store.StRaion', {
    extend: 'Ext.data.Store',
    alias: 'store.stRaion',

    requires: [
        'yis.model.MdRaion',
        'Ext.data.proxy.Direct',
        'yis.DirectAPI',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'stRaion',
            model: 'yis.model.MdRaion',
            proxy: {
                type: 'direct',
                extraParams: {
                    what: 'raion'
                },
                directFn: 'QueryAddress.getResults',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});