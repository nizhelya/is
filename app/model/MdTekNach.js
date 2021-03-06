/*
 * File: app/model/MdTekNach.js
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

Ext.define('yis.model.MdTekNach', {
    extend: 'Ext.data.Model',
    alias: 'model.mdTekNach',

    requires: [
        'Ext.data.field.Date',
        'Ext.data.field.String',
        'Ext.data.field.Number'
    ],

    fields: [
        {
            type: 'int',
            name: 'address_id'
        },
        {
            type: 'date',
            name: 'data'
        },
        {
            type: 'string',
            name: 'fdate'
        },
        {
            type: 'string',
            name: 'usluga'
        },
        {
            type: 'string',
            name: 'period'
        },
        {
            type: 'float',
            name: 'zadol'
        },
        {
            type: 'int',
            name: 'hzadol'
        },
        {
            type: 'string',
            name: 'edizm'
        },
        {
            type: 'float',
            name: 'qty'
        },
        {
            type: 'float',
            name: 'tarif'
        },
        {
            type: 'float',
            name: 'nachisleno'
        },
        {
            type: 'float',
            name: 'perer'
        },
        {
            type: 'float',
            name: 'budjet'
        },
        {
            type: 'float',
            name: 'itogo'
        },
        {
            type: 'float',
            name: 'oplacheno'
        },
        {
            type: 'float',
            name: 'subsidia'
        },
        {
            type: 'float',
            name: 'dolg'
        },
        {
            type: 'int',
            name: 'hdolg'
        },
        {
            type: 'int',
            name: 'god'
        },
        {
            type: 'int',
            name: 'teplomer_id'
        },
        {
            type: 'int',
            name: 'dteplomer_id'
        },
        {
            type: 'int',
            name: 'dvodomer_id'
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
            type: 'int',
            name: 'raion_id'
        },
        {
            type: 'int',
            name: 'house_id'
        },
        {
            type: 'string',
            name: 'mec'
        },
        {
            type: 'int',
            name: 'people'
        },
        {
            type: 'float',
            name: 'kub'
        },
        {
            type: 'float',
            name: 'xkub'
        },
        {
            type: 'float',
            name: 'gkub'
        },
        {
            type: 'float',
            name: 'square'
        },
        {
            type: 'float',
            name: 'area_nach'
        },
        {
            type: 'float',
            name: 'gkal'
        },
        {
            type: 'float',
            name: 'gkal_dt'
        },
        {
            type: 'float',
            name: 'gkm2'
        },
        {
            type: 'float',
            name: 'gkm3'
        },
        {
            type: 'float',
            name: 'norma'
        },
        {
            type: 'float',
            name: 'xvoda'
        },
        {
            type: 'float',
            name: 'otoplenie'
        },
        {
            type: 'float',
            name: 'gvoda'
        },
        {
            type: 'float',
            name: 'podogrev'
        },
        {
            type: 'float',
            name: 'gkal_perer'
        },
        {
            type: 'float',
            name: 'gkal_y_ot'
        },
        {
            type: 'float',
            name: 'tarif_perer'
        },
        {
            type: 'int',
            name: 'day_xv'
        },
        {
            type: 'int',
            name: 'day_gv'
        },
        {
            type: 'float',
            name: 'perer_gkal'
        },
        {
            type: 'float',
            name: 'gkm2_perer'
        },
        {
            type: 'float',
            name: 'ptarif'
        },
        {
            type: 'float',
            name: 'tbo'
        },
        {
            type: 'float',
            name: 'kvartplata'
        },
        {
            type: 'float',
            name: 'budjet_mop'
        },
        {
            type: 'float',
            name: 'mop'
        },
        {
            type: 'float',
            name: 'gkm2_mop'
        },
        {
            type: 'float',
            name: 'gkal_mop'
        },
        {
            type: 'float',
            name: 'square_lg'
        },
        {
            type: 'float',
            name: 'gkub_lg'
        },
        {
            type: 'float',
            name: 'xkub_lg'
        },
        {
            type: 'float',
            name: 'pkub'
        },
        {
            type: 'float',
            name: 'norma_xv'
        },
        {
            type: 'float',
            name: 'norma_gv'
        },
        {
            type: 'float',
            name: 'nrx_gvs_d'
        },
        {
            type: 'date',
            name: 'date_in'
        },
        {
            type: 'date',
            name: 'data_perer'
        },
        {
            type: 'int',
            name: 'people_lg'
        },
        {
            type: 'string',
            name: 'note'
        },
        {
            type: 'string',
            name: 'info'
        },
        {
            type: 'string',
            name: 'operator'
        },
        {
            type: 'string',
            name: 'MyField601'
        }
    ]
});