/*
 * File: app/view/flat/PnIpay.js
 * Date: Fri Mar 20 2015 09:30:40 GMT+0200 (EET)
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

Ext.define('yis.view.flat.PnIpay', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.pnIpay',

    requires: [
        'yis.view.flat.PnIpayViewModel'
    ],

    viewModel: {
        type: 'pnIpay'
    },
    height: 250,
    id: 'pnIpay',
    width: 400,
    layout: 'fit',
    closable: true,
    title: 'My Panel'

});