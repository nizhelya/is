/*
 * File: app/model/MdAppHistory.js
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

Ext.define('yis.model.MdAppHistory', {
    extend: 'Ext.data.Model',
    alias: 'model.mdAppHistory',

    requires: [
        'Ext.data.field.String',
        'Ext.data.field.Date',
        'Ext.data.field.Number'
    ],

    fields: [
        {
            type: 'string',
            name: 'key'
        },
        {
            type: 'int',
            name: 'raion_id'
        },
        {
            type: 'int',
            name: 'street_id'
        },
        {
            type: 'int',
            name: 'house_id'
        },
        {
            type: 'int',
            name: 'address_id'
        },
        {
            type: 'string',
            name: 'raion'
        },
        {
            type: 'string',
            name: 'street'
        },
        {
            type: 'string',
            name: 'address'
        },
        {
            type: 'string',
            name: 'lift'
        },
        {
            type: 'int',
            name: 'room'
        },
        {
            type: 'string',
            name: 'number_order'
        },
        {
            type: 'date',
            name: 'fdate_order'
        },
        {
            type: 'string',
            name: 'owner'
        },
        {
            type: 'string',
            name: 'nanim'
        },
        {
            type: 'string',
            name: 'privat'
        },
        {
            type: 'int',
            name: 'tenant'
        },
        {
            type: 'int',
            name: 'absent'
        },
        {
            type: 'int',
            name: 'podnan'
        },
        {
            type: 'int',
            name: 'lgotchik'
        },
        {
            type: 'float',
            name: 'area_full'
        },
        {
            type: 'float',
            name: 'area_life'
        },
        {
            type: 'float',
            name: 'area_balk'
        },
        {
            type: 'float',
            name: 'area_dop'
        },
        {
            type: 'string',
            name: 'kvartplata'
        },
        {
            type: 'string',
            name: 'otoplenie'
        },
        {
            type: 'string',
            name: 'podogrev'
        },
        {
            type: 'string',
            name: 'xvoda'
        },
        {
            type: 'string',
            name: 'stoki'
        },
        {
            type: 'string',
            name: 'tbo'
        },
        {
            type: 'string',
            name: 'subsidia'
        },
        {
            type: 'string',
            name: 'vgvoda'
        },
        {
            type: 'string',
            name: 'vxvoda'
        },
        {
            type: 'string',
            name: 'teplomer'
        },
        {
            type: 'string',
            name: 'boiler'
        },
        {
            type: 'string',
            name: 'what_change'
        },
        {
            type: 'date',
            name: 'fdate_change'
        },
        {
            type: 'string',
            name: 'operator'
        },
        {
            type: 'string',
            name: 'floor'
        },
        {
            type: 'string',
            name: 'house'
        }
    ]
});