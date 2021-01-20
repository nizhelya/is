/*
 * File: app/view/user/WinAddMyFlatViewController.js
 * Date: Fri May 08 2015 20:27:21 GMT+0300 (EEST)
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

Ext.define('yis.view.user.WinAddMyFlatViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.winAddMyFlat',

    onCbViborStreetSelect: function(combo, record, eOpts) {

        //COMBO

        var cbHouse = Ext.getCmp("cbViborHouse");

        //STORE

        var stHouses = Ext.data.StoreManager.get("StHouses");
        var stAddress = Ext.data.StoreManager.get("StAddress");

        var store =combo.getStore();

        var selected = record;

        //LOGIKA

        if ((selected) && !store.getById(selected.get('street_id'))) {
            // console.log(selected);
            cbHouse.clearValue();
            stHouses.removeAll();
            stAddress.removeAll();
            if (selected.get('privat')) {

                stAddress.load({
                    params: {
                        what:'HousesFromStreet',
                        privat: selected.get('privat'),
                        what_id: selected.get('street_id')
                    },
                    scope: this
                });


            }else{

                stHouses.load({
                    params: {
                        what:'HousesFromStreet',
                        privat: selected.get('privat'),
                        what_id: selected.get('street_id')
                    },
                    scope: this
                });

            }

        }
    },

    onCbViborHouseSelect: function(combo, record, eOpts) {
        //in use

        //STORE
        var stAddress = Ext.data.StoreManager.get('StAddress');
        var store =combo.getStore();

        var selected = record;

        //LOGIKA

        if ((selected) && !store.getById(selected.get('house_id'))) {
            stAddress.removeAll();
            stAddress.load({
                params: {
                    what:'AddressFromHouses',
                    what_id: selected.get('house_id')
                },
                scope: this
            });

        }
    }

});