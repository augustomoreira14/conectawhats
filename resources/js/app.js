
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Lang = require('lang.js');

import translations from './vue-translations.js';

var language = new Lang();
language.setLocale("pt_BR");

language.setMessages(translations);

Vue.filter('trans', (...args) => {
    return language.get(...args);
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        typeMessage: 'abandoned_checkout',
        order: null,
        customer: null,
        messages: null,
        loading: false,
        message: null,
        urlAction: null,
        pathName: null,
        menuToggled: null,
        ids: [],
        itemTutorial: null
    },
    created(){
        this.pathName = window.location.pathname;
        if(this.readCookie('menu-togled') !== 'false'){
           this.menuToggled = true; 
        }else{
           this.menuToggled = false;
        }
        
    },
    mounted(){
        // $('#exampleModalCenter').modal('modalTutorial');
    },
    computed: {
        isMenuConfig(){
            return this.pathName === "/gateways" || this.pathName === '/messages';
        }
    },
    methods: {
        openTutorial(item){
            this.itemTutorial = item;
            $('#modalTutorial').modal({
                'backdrop': 'static'
            });
        },
        closeTutorial(){
            $('#modalTutorial').modal('hide');
            this.itemTutorial = null;
        },
        checkAll(ids, event){
            if(event.target.checked){
                this.ids = ids;
            }else{
                this.ids = [];
            }
        },
        toggleMenu(){
            
            //console.log(this.menuToggled);
            this.menuToggled = !this.menuToggled;
            this.setCookie('menu-togled', this.menuToggled, 1);
        },
        setCookie(cname, cvalue, exdays){
            var d = new Date();
            d.setTime(d.getTime() + (exdays*1000*60*60*24));
            var expires = "expires=" + d.toGMTString();
            window.document.cookie = cname+"="+cvalue+"; "+expires;         
        },
        readCookie(cname){
            var name = cname + "=";
            var cArr = window.document.cookie.split(';');

            for(var i=0; i<cArr.length; i++) {
                var c = cArr[i].trim();
                if (c.indexOf(name) == 0) 
                    return c.substring(name.length, c.length);
            }

            return "";
        },
        openModalUpdate(item, url){
            $('#modalVisualizacao').modal('show');
        },
        tabMessage(type){
            this.typeMessage = type;
        },
        showSendMessage(order, url){
            this.customer = order.customer;
            this.order = order;
            this.urlAction = url;
            this.typeMessage = order.flow;
            this.messages = null;
            this.message = null;
            this.loading = true;

            $('#modalEnvio').modal('show');
            this.updateMessages((r) => {
                if(r.data.length > 0){
                    this.messages = r.data;
                    this.message = this.messages[0];
                }
                this.loading = false;
            });
        },
        updateMessages(callback){
            axios.get('/api/messages_processeds', {
                params: {
                    flow: this.typeMessage,
                    order: this.customer.order_id
                }          
            }).then(callback);
        },
        sendMessage(){
            var url = "https://api.whatsapp.com/send?phone="+ this.customer.phone.whatsapp + "&text=" + encodeURI(this.message.message);
            window.open(url);
        }
    }
});
