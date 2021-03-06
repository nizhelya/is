/*
 * File: app/model/MdHVodomer.js
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

Ext.define('yis.model.MdHVodomer', {
    extend: 'Ext.data.Model',
    alias: 'model.mdHVodomer',

    requires: [
        'Ext.data.field.Integer',
        'Ext.data.field.String'
    ],

    fields: [
        {
            type: 'int',
            name: 'address_id'
        },
        {
            type: 'int',
            name: 'house_id'
        },
        {
            type: 'string',
            name: 'address'
        },
        {
            type: 'int',
            name: 'nomer'
        },
        {
            type: 'string',
            name: 'model'
        },
        {
            type: 'string',
            name: 'voda'
        },
        {
            type: 'string',
            name: 'place'
        },
        {
            type: 'string',
            name: 'position'
        }
    ]
});