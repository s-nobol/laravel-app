<template>
<div class=" bg-white">
    <nav class="navbar bg-white">
    
        <div class="container ">
            <RouterLink class="navbar__brand" to="/">
              Vuesplash
            </RouterLink>
            
            <div class="">
                <button v-if="isLogin"  class="btn btn-primary" @click="showForm = ! showForm" >記事の作成</button>
                <span v-if="isLogin" class="navbar__item" @click="dropdown = ! dropdown ">{{ username }}</span>
                
                <button v-if="isLogin"  @click="logout" class="btn" >ログアウト</button>
                
                <div v-else class="">
                
                
                    <!--モーダルクラス作成-->
                    <button @click="modal = 1" class="btn ">ログイン</button>
                    <button @click="modal = 2" class="btn btn-primary">新規登録</button>
                                
                    <transition name="fade" >
                        <Modal v-if="modal" :modal="modal" @close="onCloseModal" />
                    </transition >
                </div>
            </div>
        
        </div>
        
    </nav>
    <!--記事投稿画面-->
    <PostForm v-model="showForm"/>
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

import Modal from './modal/Modal.vue'

import PostForm from './PostForm.vue'

export default {
    
    components: { Modal,  PostForm },
    data(){
        return{
            modal: false,
            showForm: false,
        }
    },
    computed:{
        apiStatus () {
            return this.$store.state.auth.apiStatus
        },
        isLogin () {
            return this.$store.getters['auth/check']
        },
        username () {
            return this.$store.getters['auth/username']
        }
    },
    methods:{
        
      
        
        async logout () {
            await this.$store.dispatch('auth/logout')
            if (this.apiStatus) {
                console.log("logout")
                this.$router.push('/')
            }
        },
        onCloseModal() {
          this.modal = false
        },
    },
}
</script>