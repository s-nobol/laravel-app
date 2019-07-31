<template>
<div class=" bg-white">
    <nav class="navbar bg-white">
    
        <div class="container ">
            <RouterLink class="navbar__brand" to="/">ホーム</RouterLink>
            
                <div v-if="currentUser">
                    <button v-if="currentUser"  class="btn btn-primary" @click="showForm = ! showForm" >記事の作成</button>
                    
                    <RouterLink class="" :to="`/users/${currentUser.id}`">
                        <img src="/noimage.jpg" class="rounded-circle" style="width: 30px;"></img>
                    </RouterLink>
                    <span v-if="currentUser" class="navbar__item" @click="dropdown = ! dropdown ">{{ currentUser.name }}</span>
                    <button v-if="currentUser"  @click="logout" class="btn" >ログアウト</button>
                    
                </div>
                
                <div v-else class="">
                    <!--モーダルクラス作成-->
                    <button @click="modal = 1" class="btn ">ログイン</button>
                    <button @click="modal = 2" class="btn btn-primary">新規登録</button>
                                
                </div>
                
                
        </div>
    </nav>
    
    <!--モーダル-->
    <transition name="fade" >
        <Modal v-if="modal" :modal="modal" @close="onCloseModal" />
    </transition >
    
    <!--記事投稿画面-->
    <transition name="slide_down">
        <div v-if="showForm" class="post-form">
            <PostForm v-model="showForm"/>
        </div>
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
.post-form{
    height: 300px;
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
        currentUser(){
            return this.$store.getters['auth/currentUser']
        }
    },
    methods:{
        async logout () {
            await this.$store.dispatch('auth/logout')
            if (this.apiStatus) {
                console.log("logout")
                // window.location.reload();
            }
        },
        onCloseModal() {
            this.modal = false
        },
    },
}
</script>