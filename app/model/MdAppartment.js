/*
 * File: app/model/MdAppartment.js
 * Date: Wed Apr 22 2020 22:14:12 GMT+0300 (EEST)
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

Ext.define('yis.model.MdAppartment', {
    extend: 'Ext.data.Model',
    alias: 'model.mdAppartment',

    requires: [
        'Ext.data.field.String',
        'Ext.data.field.Date',
        'Ext.data.field.Number'
    ],

    fields: [
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
            name: 'order'
        },
        {
            type: 'date',
            name: 'data_ordera'
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
            type: 'string',
            name: 'lgota'
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
            name: 'voda'
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
            name: 'data_change'
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
        },
        {
            name: 'raion'
        },
        {
            type: 'string',
            name: 'street'
        },
        {
            type: 'string',
            name: 'aggr_kv'
        },
        {
            type: 'string',
            name: 'aggr_tbo'
        },
        {
            type: 'string',
            name: 'aggr_teplo'
        },
        {
            type: 'string',
            name: 'aggr_voda'
        },
        {
            type: 'float',
            name: 'tarif_ot'
        },
        {
            type: 'float',
            name: 'tarif_gv'
        },
        {
            type: 'float',
            name: 'tarif_xv'
        },
        {
            type: 'float',
            name: 'tarif_st'
        },
        {
            type: 'float',
            name: 'tarif_tbo'
        },
        {
            type: 'float',
            name: 'tarif_kv'
        },
        {
            type: 'string',
            name: 'dog_ytke'
        },
        {
            type: 'date',
            name: 'dog_ytke_data'
        },
        {
            type: 'string',
            name: 'inn'
        },
        {
            type: 'string',
            name: 'passport'
        },
        {
            type: 'string',
            name: 'vidan'
        },
        {
            type: 'date',
            name: 'viddata'
        },
        {
            type: 'int',
            name: 'dteplomer_id'
        },
        {
            type: 'int',
            name: 'teplomer_id'
        },
        {
            type: 'string',
            name: 'chdate'
        },
        {
            type: 'string',
            name: 'dog_vik'
        },
        {
            type: 'date',
            name: 'dog_vik_data'
        },
        {
            type: 'int',
            name: 'ipay'
        }
    ]
});