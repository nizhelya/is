/*
 * File: app/model/MdAppAgreement.js
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

Ext.define('yis.model.MdAppAgreement', {
    extend: 'Ext.data.Model',
    alias: 'model.mdAppAgreement',

    requires: [
        'Ext.data.field.Integer',
        'Ext.data.field.Date',
        'Ext.data.field.String'
    ],

    idProperty: 'address_id',

    fields: [
        {
            type: 'int',
            name: 'address_id'
        },
        {
            type: 'date',
            name: 'date_change'
        },
        {
            type: 'string',
            name: 'aggr_kvartpl'
        },
        {
            type: 'string',
            name: 'aggr_teplo'
        },
        {
            type: 'string',
            name: 'aggr_stoki'
        },
        {
            type: 'string',
            name: 'aggr_voda'
        },
        {
            type: 'string',
            name: 'aggr_tbo'
        },
        {
            type: 'string',
            name: 'phone'
        },
        {
            type: 'string',
            name: 'what_change'
        },
        {
            type: 'string',
            name: 'operator'
        }
    ]
});