<template>
  <div>
    
    
    <!--ヘッダー-->
    <header>
      <Navbar />
    </header>
    
    <!--メイン-->
    <main>
      <div class="container">
        <RouterView />
      </div>
    </main>
    
    <!--フッター-->
    <!--<Footer2 />-->
    
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
                if (val === INTERNAL_SERVER_ERROR) {
                    this.$router.push('/500')
                    
                } else if (val === UNAUTHORIZED) {
                  
                    await axios.get('/api/refresh-token')
                    this.$store.commit('auth/setUser', null)
                    // ログインView表示
                    this.modal = 1
                    
                } else if (val === NOT_FOUND) {
                    this.$router.push('/not-found')
                    
                } else if (val === 401 ){
                    this.modal = 1
                }
                this.$store.commit('error/setCode', null)
                
            },
            immediate: true
        },
        
        $route () {
            this.$store.commit('error/setCode', null)
        }
    }
}
</script>