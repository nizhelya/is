/*
 * File: app/store/StMyFlat.js
 * Date: Fri Mar 20 2015 09:30:45 GMT+0200 (EET)
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

Ext.define('yis.store.StMyFlat', {
    extend: 'Ext.data.Store',
    alias: 'store.stMyFlat',

    requires: [
        'yis.model.MdMyFlat',
        'Ext.data.proxy.Direct',
        'yis.DirectAPI',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'stMyFlat',
            model: 'yis.model.MdMyFlat',
            proxy: {
                type: 'direct',
                api: {
                    create: 'QueryMyFlat.createRecord',
                    read: 'QueryMyFlat.getResults',
                    update: 'QueryMyFlat.updateRecords',
                    destroy: 'QueryMyFlat.destroyRecord'
                },
                reader: {
                    type: 'json',
                    rootProperty: 'results'
                }
            }
        }, cfg)]);
    }
});