/*
 * File: app/controller/CrAppTeplomer.js
 * Date: Tue Dec 22 2020 15:34:26 GMT+0200 (EET)
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

Ext.define('yis.controller.CrAppTeplomer', {
    extend: 'Ext.app.Controller',
    alias: 'controller.crAppTeplomer',

    control: {
        "#addAppTeplomer": {
            click: 'onAddAppTeplomerClick'
        },
        "#newPokAppTepl": {
            specialkey: 'onNewPokAppTeplSpecialkey'
        },
        "#btAddTeplomer": {
            click: 'onBtAddTeplomerClick'
        },
        "#tabAppTeplomer": {
            activate: 'onTabAppTeplomerActivate'
        }
    },

    onAddAppTeplomerClick: function(button, e, eOpts) {
        //in use
        var me=this;
        //STORE

        var stUser = Ext.data.StoreManager.get("StUser");
        var StDTeplomerCb = Ext.data.StoreManager.get("StDTeplomerCb");//QueryTeplomer.getResults  <AllPokTeplomera>

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var house_id = values.get('house_id');

        //LOGIKA
        values.set({'vibor':'addAppTeplomer'});
        stUser.sync();

        var dt = new Date();
        var WinAddTeplomer = me.getWinAddTeplomer();
        var form = WinAddTeplomer.down('#fmAddTeplomer');

        /*
        LOGIKA
        */

        StDTeplomerCb.removeAll();
        StDTeplomerCb.load({
            params: {
                what_id:house_id,
                what:'DteplomerHouse'
            },
            scope:this
        });
        form.getForm().findField('pdate').setValue(Ext.Date.format(dt, 'Y-m-d'));
        form.getForm().findField('sdate').setValue(Ext.Date.format(dt, 'Y-m-d'));
        WinAddTeplomer.show();




    },

    onNewPokAppTeplSpecialkey: function(field, e, eOpts) {
        var value = field.getValue();
        if (e.getKey() === e.ENTER && !Ext.isEmpty(value)) {
            this.onInsTekPokTeplomerClick();
        }
    },

    onBtAddTeplomerClick: function(button, e, eOpts) {
        // in use
        var me = this;
        //CONTROLLER

        var CrOrgTeplomer = this.application.getController('CrOrgTeplomer');
        var value = button.findParentByType('form').getValues();
        //STORE

        var stUser = Ext.data.StoreManager.get("StUser");
        var values =stUser.getAt(0);
        var vibor = values.get('vibor');
        this.getWinAddTeplomer().close();
        switch (vibor){
            case 'addOrgTeplomer':// ВЫБРАНА ОРГАНИЗАЦИЯ
            CrOrgTeplomer.addOrgTeplomer(value);
            break;
            case 'editOrgTeplomer':// ВЫБРАНА ОРГАНИЗАЦИЯ  - edit
            CrOrgTeplomer.editOrgTeplomer(value);
            break;
            case 'changeOrgTeplomer':// ВЫБРАНА ОРГАНИЗАЦИЯ  - замена
            CrOrgTeplomer.changeOrgTeplomer(value);
            break;
            case 'addAppTeplomer':  // ВЫБРАНА КВАРТИРА
            me.addAppTeplomer(value);
            break;
            case 'editAppTeplomer':// ВЫБРАНА КВАРТИРА  - edit
            me.editAppTeplomer(value);
            break;
            case 'changeAppTeplomer':  // ВЫБРАНА КВАРТИРА
            me.changeAppTeplomer(value);
            break;
        }
    },

    onTabAppTeplomerActivate: function(component, eOpts) {
        var stUser = Ext.data.StoreManager.get("StUser");
        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');
        var address_id = values.get('address_id');
        var address = values.get('address');
        var house_id = values.get('house_id');
        var fmAppTeplomer = Ext.getCmp('fmAppTeplomer');
        var stTeplomer = Ext.data.StoreManager.get("StTeplomer");
        var stHTeplomer = Ext.data.StoreManager.get("StHTeplomer");
        var StAllPokTeplomera = Ext.data.StoreManager.get("StAllPokTeplomera");
        StAllPokTeplomera.removeAll();
        fmAppTeplomer.getForm().reset();
        stTeplomer.load({
            params: {
                what:'AppTeplomer',
                what_id: address_id,
                address_id: address_id,
                login:login,
                password:password
            },
            scope:this
        });
        stHTeplomer.load({
            params: {
                what:'AppHTeplomer',
                what_id: address_id,
                address_id: address_id,
                login:login,
                password:password
            },
            scope:this
        });

    }

});