/*
 * File: app.js
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

// @require @packageOverrides
Ext.Loader.setConfig({

});


Ext.application({
    models: [
        'MdHouses',
        'MdMyFlat',
        'MdOplata',
        'MdUser',
        'MdTekNach',
        'MdStreet',
        'MdTekNachKassa',
        'MdNachisleno',
        'MdLoginLocal',
        'MdAppAgreement',
        'MdAddress',
        'MdHVodomer',
        'MdVodomer',
        'MdAppartment',
        'MdLogin',
        'MdRaion',
        'MdWater',
        'MdPhoneMaska',
        'MdAppHistory',
        'MdTekPokVodomera',
        'MdLgotnik',
        'MdPriborUcheta'
    ],
    stores: [
        'StNachisleno',
        'StLoginLocal',
        'StHouses',
        'StMyFlat',
        'StHAppartment',
        'StHVodomer',
        'StOplata',
        'StReport',
        'StLgotnik',
        'StStreet',
        'StTekPokVodomera',
        'StHTeplomer',
        'StUser',
        'StTekNachKassa',
        'StAppartment',
        'StAddress',
        'StTeplomer',
        'StAllPokTeplomera',
        'StPayment',
        'StVodomerKassa',
        'StLogin',
        'StVodomer',
        'StRaion',
        'StWater',
        'StTekOplata',
        'StTekPokTeplomera',
        'StTekNachApp',
        'StLgotaNachVoda',
        'StAddMyFlat',
        'StFamaly'
    ],
    views: [
        'flat.TabNach',
        'VpIsCity',
        'flat.TabLogin',
        'flat.TabMarfinBank',
        'user.WinAddMyFlat',
        'flat.WinIpay',
        'user.TabReport',
        'NumberFieldDolg',
        'user.WinActivationConfirm',
        'NFVodomer',
        'NFNach',
        'user.WinRegistration',
        'flat.PnIpay',
        'flat.TabInfoApp',
        'flat.TabAppOplata',
        'user.WinEmailConfirm',
        'FieldNach1',
        'NFTarif1',
        'flat.tabAppBti',
        'flat.TabAppTeplomer',
        'flat.TabAppVodomer',
        'flat.TabNachApp'
    ],
    controllers: [
        'User',
        'Vodomer',
        'CrMyApp',
        'CrAppNach',
        'CrAppTeplomer'
    ],
    name: 'yis',

    launch: function() {
        Ext.create('yis.view.VpIsCity');
        var m=Ext.isObject(Ext.get('loading-mask'));
        //   console.log(m);

        //закрываем значок загрузка...
        if (m) {
            setTimeout(function(){
                Ext.get('loading').remove();
                Ext.get('loading-mask').fadeOut({remove:true});
            }, 250);
        }


    }

});
