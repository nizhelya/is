/*
 * File: app/controller/User.js
 * Date: Tue Dec 01 2020 02:02:27 GMT+0200 (EET)
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

Ext.define('yis.controller.User', {
    extend: 'Ext.app.Controller',

    views: [
        'user.WinRegistration',
        'user.WinEmailConfirm'
    ],

    refs: {
        WinRegistration: {
            selector: 'winRegistration',
            xtype: 'winRegistration'
        },
        WinEmailConfirm: {
            autoCreate: true,
            forceCreate: true,
            selector: 'winEmailConfirm',
            xtype: 'winEmailConfirm'
        },
        GrAddress: '#grAddress',
        VpIsCity: 'vpIsCity',
        LeftPanelMenu: '#leftPanelMenu',
        WinActivationConfirm: '#winActivationConfirm',
        cbMyFlat: '#cbMyFlat',
        CbViborHouse: '#cbViborHouse',
        FmLogin: '#fmLogin',
        cbViborStreet: '#cbViborStreet',
        FmRegistration: '#fmRegistration',
        WinActivationConfirm: {
            selector: 'winActivationConfirm',
            xtype: 'winActivationConfirm'
        }
    },

    control: {
        "#btnRegistrationForm": {
            click: 'onBtnRegistrationFormClick'
        },
        "#btnInput": {
            click: 'onBtnInputClick'
        },
        "#btnConfirmEmailClose": {
            click: 'onBtnConfirmEmailCloseClick'
        },
        "#btnConfirmActivationClose": {
            click: 'onBtnConfirmActivationCloseClick',
            click: 'onBtnConfirmActivationCloseClick'
        },
        "winEmailConfirm": {
            beforeclose: 'onWindowBeforeClose'
        },
        "#tabMenuMyFlat": {
            activate: 'onTabMenuMyFlatActivate'
        },
        "#btnAvtorisazia": {
            click: 'onBtnAvtorisaziaClick'
        },
        "#btnRegistration": {
            click: 'onBtnRegistrationClick'
        }
    },

    onBtnRegistrationFormClick: function(button, e, eOpts) {
        // in use
        var me = this;
        var win = me.getWinRegistration();
        var values=me.getFmRegistration().getValues();
        QueryUserLogin.checkLogin(values,function(results){
            if(results.success){
                // console.log(results.success);
                Ext.MessageBox.show({
                    title: "Регистрация",
                    msg: "Логин "+ results.login+" уже используется!",
                    buttons: Ext.MessageBox.OK,
                    icon: Ext.MessageBox.WARNING
                });
            }else{
                win.hide();
                var myMask=Ext.MessageBox.wait("Отправка почты.Ожидайте...", "Регистрация...");

                QueryUserLogin.registration(values,function(results){
                    if(results.send_email && results.okey){
                        myMask.close();
                        var registrazia = Ext.ClassManager.instantiateByAlias('widget.winEmailConfirm').show();

                    } else {
                        myMask.close();

                        if(!results.send_email){
                            Ext.MessageBox.show({
                                title: 'Регистрация',
                                msg: 'Не могу выслать письмо на этот Email ,<br>повторить попытку ?',
                                buttons: Ext.MessageBox.OKCANCEL,
                                icon: Ext.MessageBox.WARNING,
                                fn:function(btn){
                                    if(btn=='ok'){
                                        win.show();
                                    } else {
                                        win.close();
                                    }
                                }
                            });
                        } else {
                            Ext.MessageBox.show({
                                title: 'Регистрация',
                                msg: 'Регистрация не выполнена, повторить попытку ?',
                                buttons: Ext.MessageBox.OKCANCEL,
                                icon: Ext.MessageBox.WARNING,
                                fn:function(btn){
                                    if(btn=='ok'){
                                        win.show();
                                    } else {
                                        win.close();
                                    }
                                }
                            });
                        }

                    }
                });

            }
        });
    },

    onBtnInputClick: function(button, e, eOpts) {
        // in use
        var me = this;
        var win = me.getWinRegistration();
        var tab = win.down('#pnTabRegistrazia');
        var btnRegistration = Ext.getCmp('btnRegistration');
        var btnAvtorisazia = Ext.getCmp('btnAvtorisazia');

        var showLogin = Ext.getCmp('showLogin');
        var form = button.findParentByType('form');
        var chekLogin = Ext.getCmp('chekLogin');
        var values = button.findParentByType('form').getValues();
        var leftPanelMenu  = Ext.getCmp('leftPanelMenu');
        var role = 0;
        var attempt = 0;
        //STORE
        var storeLocal = Ext.data.StoreManager.get("StLoginLocal");
        var StUser = Ext.data.StoreManager.get("StUser");
        var StMyFlat = Ext.data.StoreManager.get("StMyFlat");
        //var StAddMyFlat = Ext.data.StoreManager.get("StAddMyFlat");

        //var val1 =StUser.getAt(0);
        //console.log(val1);


        //    this.getWinRegistration().close();

        //LOGIKA
        attempt += parseInt(values.attempt,10)+1 ;
        QueryUserLogin.login(values,function(results){
            if (results.success===true){
                // console.log(results.data[0].login);
                if (results.data[0].active==="1"){
                    StUser.add({login:results.data[0].login,
                                user_id:results.data[0].user_id,
                                password:values.password,
                                role:results.data[0].role,
                                email:results.data[0].email,
                                firstname:results.data[0].firstname,
                                lastname:results.data[0].lastname,
                                surname:results.data[0].surname,
                                remember:results.data[0].remember});

                    StUser.sync();
                    role = results.data[0].role;
                    if((values.memorize)){
                        // проверяем нужно ли сохранять его в локальном хранилище, если да(remember=1)
                        // получаем обьект локального хранилища StUserLocal и добавляем в него пользователя
                        // после чего показываем окно завершения регистрации
                        storeLocal.load();
                        storeLocal.add({login:results.data[0].login,
                                        user_id:results.data[0].user_id,
                                        password:values.password,
                                        role:results.data[0].role,
                                        email:results.data[0].email,
                                        firstname:results.data[0].firstname,
                                        lastname:results.data[0].lastname,
                                        surname:results.data[0].surname,
                                        remember:results.data[0].remember});
                        storeLocal.sync();

                    }
                    if((values.erase)){
                        // проверяем нужно ли удалить пользователя из локального хранилища, если да(erase=1)
                        // Получаем обьект хранилища StLogin  и загружаем  в него c сервера данные о пользователе
                        // получаем обьект локального хранилища StUserLocal и удаляем из него пользователя
                        var r = storeLocal.last();
                        storeLocal.remove(r);
                        storeLocal.sync();
                        Ext.MessageBox.show({
                            title: 'Авторизация',
                            msg: '<center> До свидания !!!</center>',
                            buttons: null,
                            icon: Ext.MessageBox.ERROR
                        });
                        location.href = "_blank" ;
                    }
                    // console.log(role);

                    if(role !==0){
                        // leftPanelMenu.child('#tabAdminka').tab.hide();
                    }

                    StMyFlat.load({
                        params:{
                            user_id:results.data[0].user_id
                        },
                        scope: this
                    });
                    //StAddMyFlat.load();
                    btnAvtorisazia.setText('<center>Выход</center>');
                    showLogin.setText(results.data[0].login).show();
                    btnRegistration.hide();


                    win.close();

                } else {

                    Ext.MessageBox.show({
                        title: 'Авторизация',
                        msg: 'Учетная запись не активирована!<br>Вы должны повторно пройти регистрацию',
                        buttons: Ext.MessageBox.OK,
                        buttonText:{
                            ok: "Закрыть!"
                        },
                        icon: Ext.MessageBox.ERROR
                    });
                    setTimeout(function(){
                        tab.child('#pnLogin').setDisabled(true);
                        tab.child('#tabRegistration').setDisabled(false);
                        tab.setActiveTab(1);
                    }, 4000);

                }


            } else {

                if (attempt>5){
                    Ext.MessageBox.show({
                        title: 'Авторизация',
                        msg: '<center>Вы исчерпали количество попыток !!! <br> Логин или пароль неверный, <br> До свидания !!!</center>',
                        buttons: null,
                        icon: Ext.MessageBox.ERROR
                    });
                    setTimeout(function(){
                        location.href = "_blank";

                    }, 4000);
                }
                form.getForm().findField('attempt').setValue(attempt);
                chekLogin.setText('Логин или пароль неверный. Попытка № '+attempt).show();
            }
        });

    },

    onBtnConfirmEmailCloseClick: function(button, e, eOpts) {
        //in use
        var me = this;
        Ext.getCmp('winEmailConfirm').close();

    },

    onBtnConfirmActivationCloseClick: function(button, e, eOpts) {
        //in use
        var me = this;
        Ext.getCmp('winActivationConfirm').close();
    },

    onWindowBeforeClose: function(panel, eOpts) {
        //in use
        var me = this;
        var win = me.getWinRegistration().close();
    },

    onTabMenuMyFlatActivate: function(component, eOpts) {
        //in use
        var me =this;
        //console.log(me);
        var tab  =Ext.getCmp('leftPanelMenu');

        var StUser = Ext.data.StoreManager.get("StUser");
        var storeMyFlat = Ext.data.StoreManager.get("StMyFlat");


        if(!StUser.data.length){
            Ext.MessageBox.confirm({
                title: "Моя квартира",
                icon: Ext.MessageBox.INFO,
                msg: "Просматривать квартиры могут <br>только авторизированные пользователи",
                buttons:Ext.Msg.YESCANCEL,
                buttonText:{
                    ok: "Авторизация",
                    cancel: "Выход"
                },
                fn:function(btn,newValue){
                    if(btn=='cancel'){
                        tab.setActiveTab(0);
                        return false;
                    }else{
                        me.onBtnAvtorisaziaClick();

                    }
                }
            });

        }else{
            var values =StUser.getAt(0);

            var user_id = values.get('user_id');

            storeMyFlat.load({
                params:{
                    user_id:user_id
                },
                callback: function(records,operation,success){
                    if(success){
                        // console.log(tab);


                        if (!records.length) {

                            Ext.MessageBox.confirm({
                                title: "Моя квартира",
                                icon: Ext.MessageBox.INFO,

                                msg: "Ваш список квартир для просмотра пустой",
                                buttons:Ext.Msg.YESCANCEL,
                                buttonText:{
                                    ok: "Добавить квартиры",
                                    cancel: "Выход"
                                },
                                fn:function(btn,newValue){
                                    if(btn=='cancel'){
                                        tab.setActiveTab('0');
                                        return false;
                                    }else{
                                        var winAddMyFlat = Ext.ClassManager.instantiateByAlias('widget.winAddMyFlat');
                                        winAddMyFlat.show();
                                    }
                                }
                            });
                        }
                    }
                }
            });
        }

    },

    onBtnConfirmActivationCloseClick: function(button, e, eOpts) {
        // in use
        var me = this;
        var win = me.getWinActivationConfirm();
        var btnRegistration = Ext.getCmp('btnRegistration');
        var btnAvtorisazia = Ext.getCmp('btnAvtorisazia');
        var showLogin = Ext.getCmp('showLogin');

        var form = button.findParentByType('form');
        var values = button.findParentByType('form').getValues();
        //STORE
        var storeLocal = Ext.data.StoreManager.get("StLoginLocal");
        var StUser = Ext.data.StoreManager.get("StUser");
        //console.log(values);


        //LOGIKA
        QueryUserLogin.login(values,function(results){
            if (results.success===true){
                if (results.data[0].active==="1"){
                    StUser.add({login:results.data[0].login,
                        user_id:results.data[0].user_id,
                        password:values.password,
                        role:results.data[0].role,
                        email:results.data[0].email,
                        firstname:results.data[0].firstname,
                        lastname:results.data[0].lastname,
                        surname:results.data[0].surname,
                    remember:results.data[0].remember});
                    StUser.sync();
                    if((values.memorize==="1")){

                        // проверяем нужно ли сохранять его в локальном хранилище, если да(remember=1)
                        // получаем обьект локального хранилища StUserLocal и добавляем в него пользователя
                        // после чего показываем окно завершения регистрации
                        storeLocal.load();
                        storeLocal.add({login:results.data[0].login,
                            user_id:results.data[0].user_id,
                            password:values.password,
                            role:results.data[0].role,
                            email:results.data[0].email,
                            firstname:results.data[0].firstname,
                            lastname:results.data[0].lastname,
                            surname:results.data[0].surname,
                        remember:results.data[0].remember});
                        storeLocal.sync();
                    }
                    btnAvtorisazia.setText('<center>Выход</center>');
                    showLogin.setText(results.data[0].login).show();
                    btnRegistration.hide();
                    win.close();

                } else {
                    Ext.MessageBox.show({
                        title: 'Авторизация',
                        msg: 'Учетная запись не активирована!<br>Вы должны повторно пройти регистрацию',
                        buttons: Ext.MessageBox.OK,
                        buttonText:{
                            ok: "Закрыть!"
                        },
                        icon: Ext.MessageBox.ERROR
                    });
                    win.close();
                }


            } else {
                Ext.MessageBox.show({
                    title: 'Авторизация',
                    msg: 'Учетная запись не активирована!<br>Вы должны повторно пройти регистрацию',
                    buttons: Ext.MessageBox.OK,
                    buttonText:{
                        ok: "Закрыть!"
                    },
                    icon: Ext.MessageBox.ERROR
                });
                win.close();

            }
        });

    },

    onBtnAvtorisaziaClick: function(button, e, eOpts) {
        //in use
        var me=this;
        //получаем обьект локального хранилища
        var storeLocal = Ext.data.StoreManager.get("StLoginLocal");
        var StUser = Ext.data.StoreManager.get("StUser");
        var StMyFlat = Ext.data.StoreManager.get("StMyFlat");
        /*
        COMPONENT

        */

        var btnAvtorisazia = Ext.getCmp('btnAvtorisazia');
        var showLogin = Ext.getCmp('showLogin');
        var btnRegistration = Ext.getCmp('btnRegistration');
        var leftPanelMenu  = Ext.getCmp('leftPanelMenu');



        if(StUser.data.length){

            Ext.MessageBox.confirm({
                title: 'Авторизация - выход',
                msg: 'Удалить ваши персональные данные с компьютера',
                buttons: Ext.MessageBox.OKCANCEL,
                icon: Ext.MessageBox.ERROR,
                buttonText:{
                    ok:'Да',
                    cancel:'Нет'
                },
                fn:function(btn,newValue){
                    if(btn=='ok'){
                        if(storeLocal.data.length){
                            //var r = storeLocal.last();
                           // storeLocal.remove(r);
                            storeLocal.removeAll();

                        }
                        StUser.removeAll();
                        StMyFlat.removeAll();
                        btnAvtorisazia.setText('<center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Авторизация</center>');
                        btnRegistration.show();
                        showLogin.hide();
                        leftPanelMenu.setActiveTab(0);
                    }else{
                        StUser.removeAll();
                        btnAvtorisazia.setText('<center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Авторизация</center>');
                        showLogin.hide();
                        leftPanelMenu.setActiveTab(0);
                    }
                }
            });
        } else {
            var win = Ext.ClassManager.instantiateByAlias('widget.winRegistration');
            var tab = win.down('#pnTabRegistrazia');
            win.show();
            var form = win.down('#fmLogin');
            var fmLogin =  form.getForm();
            var values = fmLogin.getValues();
            var info_remember = Ext.getCmp('info_remember');
            //console.log('2');


            //получаем обьект хранилища в котором будут находиться  данные о пользователе
            // загружаем сохраненные данные на машине пользователя в локальное хранилище
            storeLocal.load();
            //var user = storeLocal.last().get('login');
            var count = storeLocal.data;

            if(storeLocal.data.length){
                var login = storeLocal.last().get('login');
                var user_id = storeLocal.last().get('user_id');
                var passwd = storeLocal.last().get('password');

                if(Ext.isEmpty(login)){
                    //Проверяем локальное хранилище
                    //Если есть сохраненные данные,то
                    //находим последнюю запись и получаем ид пользователя и пароль;
                    //   info_erase.hide();
                    info_remember.show();
                    //  fmLogin.findField('erase').hide();
                    fmLogin.findField('memorize').show();
                } else {
                    fmLogin.findField('login').setValue(login);
                    fmLogin.findField('password').setValue(passwd);
                    fmLogin.findField('user_id').setValue(user_id);
                    //     fmLogin.findField('erase').show();
                    info_remember.hide();
                    //    info_erase.show();
                    fmLogin.findField('memorize').hide();
                }
            } else {
                //     info_erase.hide();
                info_remember.show();
                //     fmLogin.findField('erase').hide();
                fmLogin.findField('memorize').show();
            }
        }

    },

    onBtnRegistrationClick: function(button, e, eOpts) {
        //in use
        var win = Ext.ClassManager.instantiateByAlias('widget.winRegistration');
        var tab = win.down('#pnTabRegistrazia');
        win.show();
        tab.child('#pnLogin').setDisabled(true);
        tab.child('#tabRegistration').setDisabled(false);
        tab.setActiveTab(1);



    },

    onLaunch: function() {
        var me = this;
        var dt = new Date();
        var daym= Ext.Date.format(dt, 'dh');
        if ((daym ==="0100") || (daym ==="0101") || (daym ==="0102") || (daym ==="0103") || (daym ==="0104") || (daym ==="0105") ){
         //if ((daym ==="0100") || (daym ==="0101")  ){

            Ext.MessageBox.confirm({
                        title: 'Южненская Коммунальная Информационная Система',
                        msg: '<b>Извините</b><br><br>Идут технические работы до 6 часов утра<br><br></center>',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.INFO,
                        buttonText:{
                            ok: "Закрыть!"
                        }
             });
             }else{

        var LeftPanelMenu = me.getLeftPanelMenu();
        var showLogin = Ext.getCmp('showLogin');
        var btnRegistration = Ext.getCmp('btnRegistration');
        var btnAvtorisazia = Ext.getCmp('btnAvtorisazia');
        var params ={};
        //LOGIKA
        var login =Ext.get('login').getValue();
        var code =Ext.get('code').getValue();
        var pay_id =Ext.get('pay_id').getValue();
        //получаем обьект локального хранилища
        var store = Ext.data.StoreManager.get("StLogin");
        var storeLocal = Ext.data.StoreManager.get("StLoginLocal");
        var StUser = Ext.data.StoreManager.get("StUser");

        //console.log(Ext.Date.format(dt, 'dh'));
        //Ext.Date.between(new Date('07/01/2011'), new Date('05/01/2011'),new Date('09/01/2011')));
        //console.log(Ext.Date.Day(dt));
        //console.log(code);
        //console.log(pay_id);




        if((login.length) &&  (code.length)){
            // Если пользователь пришел по ссылке со своего email при завершении регистрации
            // Получаем обьект хранилища StLogin  и загружаем  в него c сервера данные о пользователе
            // Если успешно , проверяем нужно ли сохранять его в локальном хранилище, если да(remember=1)
            // получаем обьект локального хранилища StUserLocal и добавляем в него пользователя
            // получаем обьект  хранилища StUser и добавляем в него пользователя
            // после чего показываем окно завершения регистрации
            //console.log(login.length);
            store.load({
                params: {
                    what:'activation',
                    login:login,
                    keysend:code
                },
                callback: function(records,operation,success){
                    if(success){

                        var activation = Ext.ClassManager.instantiateByAlias('widget.winActivationConfirm');

                        var form = activation.down('#fmActivation');
                        form.getForm().findField('showLogin').setValue(records[0].data.login);
                        form.getForm().findField('login').setValue(records[0].data.login);
                        form.getForm().findField('password').setValue(records[0].data.password);
                        form.getForm().findField('memorize').setValue(records[0].data.remember);
                        activation.show();
                    }
                }
            });
        }  else if(pay_id.length){
            var myMask= Ext.Msg.show({
                title:'Оплата через сервис on-line платежей IPAY.UA ',
                msg: 'Подтверждение оплаты.Ожидайте...',
                buttons: Ext.Msg.CANCEL,
                wait: true,
                modal: true,
                icon: Ext.Msg.INFO
            });
            storeLocal.load();
            if(storeLocal.data.length){
                params = {
                    login:storeLocal.last().get('login'),
                    password:storeLocal.last().get('password')
                };

                QueryUserLogin.login(params,function(results){
                    if (results.success===true){
                        if (results.data[0].active==="1"){
                            StUser.add({login:results.data[0].login,
                                        user_id:results.data[0].user_id,
                                        role:results.data[0].role,
                                        email:results.data[0].email,
                                        firstname:results.data[0].firstname,
                                        lastname:results.data[0].lastname,
                                        surname:results.data[0].surname,
                                        remember:results.data[0].remember});
                            StUser.sync();
                            role = results.data[0].role;
                            btnAvtorisazia.setText('<center>Выход</center>');
                            showLogin.setText(results.data[0].login).show();
                            btnRegistration.hide();
                            LeftPanelMenu.setActiveTab('tabMenuMyFlat');
                        }
                    }
                });
            }
            params = {
                pay_id:pay_id,
                what:"PaymentStatus"
            };
            QueryPayment.getResults(params,function(results){
                if (results.data[0].status === "5"){
                    myMask.close();
                    var address_id = results.data[0].address_id;
                    var raion_id = results.data[0].raion_id;


                    Ext.MessageBox.confirm({
                        title: 'Оплата через сервис on-line платежей IPAY.UA ',
                        msg: '<b>Южненская Коммунальная Информационная Система</b><br>Платеж через сервис IPAY.UA обрабртан</center>',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.INFO,
                        buttonText:{
                            ok: "Закрыть!"
                        }

                    });
                }else{
                    myMask.close();
                    Ext.MessageBox.show({title: 'Оплата через сервис on-line платежей IPAY.UA ',
                                         msg: '<b>Южненская Коммунальная Информационная Система</b><br>Платеж через сервис IPAY.UA еще не обработан<br> ',
                                         buttons: Ext.MessageBox.OK,
                                         icon: Ext.MessageBox.INFO
                                        });
                }
            });
        }else {

            storeLocal.load();

            if(storeLocal.data.length){
                params = {
                    login:storeLocal.last().get('login'),
                    password:storeLocal.last().get('password')
                };

                QueryUserLogin.login(params,function(results){
                    if (results.success===true){
                        // console.log(results);

                        if (results.data[0].active==="1"){
                            StUser.add({login:results.data[0].login,
                                        user_id:results.data[0].user_id,
                                        role:results.data[0].role,
                                        email:results.data[0].email,
                                        firstname:results.data[0].firstname,
                                        lastname:results.data[0].lastname,
                                        surname:results.data[0].surname,
                                        remember:results.data[0].remember});
                            StUser.sync();
                            role = results.data[0].role;
                            btnAvtorisazia.setText('<center>Выход</center>');
                            showLogin.setText(results.data[0].login).show();
                            btnRegistration.hide();
                            LeftPanelMenu.setActiveTab('tabMenuMyFlat');

                        }
                    }
                });
            }
        }
        }

    }

});
