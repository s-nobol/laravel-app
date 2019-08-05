<template>
 <div class="bg-white">
        
        <!--ヘッダー-->
        <header>
            <Navbar />
        </header>
        
        
        <!--フラッシュ-->
        <transition name="slide_down" >
            <div v-if="message" class="flash-form">
                <div class=" container alert" :class="messageType" >{{ message }}</div>
            </div>
        </transition >
        
        
        <!--メイン-->
        <main>
            <div class="">
                <RouterView />
            </div>
        </main>
        
        
        <!--フッター-->
        <!--<Footer />-->
        
        <!--モーダル（ログイン専用のモーダルにする）--> 
        <transition name="fade" >
            <Modal v-if="modal"  @close="onCloseModal" />
        </transition >
    
 </div>
</template>

<style type="text/css">
.fade-leave-active,.fade-enter-active{
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}


.flash-form{
    height: 50px;
    overflow-y: auto;
    overflow: hidden;
}
.slide_down-enter-active, .slide_down-leave-active {
    transition: all .5s;
}
.slide_down-enter, .slide_down-leave-to {
    height: 0;
}
</style>

<script>
import Modal from './components/modal/Modal.vue'
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import { NOT_FOUND, UNAUTHORIZED, INTERNAL_SERVER_ERROR } from './util'

export default {
    components: {
        Modal,
        Navbar,
        Footer
    },
    data(){
        return{
            modal: false
        }
    },
    computed: {
        message(){
            return this.$store.state.message.content
        },
        messageType(){
            return this.$store.state.message.type
        },
        errorCode () {
            return this.$store.state.error.code
        }
    },
    methods:{
        onCloseModal(){
            this.modal = false
        }
    },
    watch: {
        errorCode: {
            async handler (val) {
                
                // サーバーエラー
                if (val === INTERNAL_SERVER_ERROR) {
                    this.$router.push('/500')
                    
                // ログインエラー
                } else if (val === UNAUTHORIZED) {
                  
                    await axios.get('/api/refresh-token')
                    this.$store.commit('auth/setUser', null)
                    this.$router.push('/401')
                    
                // クライアントユーザーエラー
                } else if( val === 401 ){
                    this.$router.push('/401')
                } else if(val === 403 ){
                    this.$router.push('/403')
                
                // ページエラー
                } else if (val === NOT_FOUND) {
                    this.$router.push('/not-found')
                    
                }else{
                }
                this.$store.commit('error/setCode', null)
                
            },
            immediate: true
        },
        
        $route () {
            this.$store.commit('error/setCode', null)
        }
    },
    created(){
    }
}
</script>