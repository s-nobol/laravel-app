<template>
<div class="">
    <nav class="navbar bg-white  nav-form">
    
        <div class="m-auto w-75" style="">
                <!--m-auto w-75-->
                <RouterLink class="navbar-brand" to="/">ホーム</RouterLink>
                
                <div v-if="currentUser" class=" nav-item float-right">
                    <div class=" float-right">
                        <button v-if="currentUser"  class="btn btn-primary"
                            @click="showForm = ! showForm" >記事の作成</button>
                        
                        <RouterLink class="" :to="`/users/${currentUser.id}`">
                            <img src="/noimage.jpg" class="rounded-circle" style="width: 30px;"></img>
                            <span v-if="currentUser" class="navbar__item" >{{ currentUser.name }}</span>
                        </RouterLink>
                        <button v-if="currentUser"  @click="logout" class="btn" >ログアウト</button>
                    </div>
                    
                    
                    <!--記事投稿画面-->
                    <transition name="fade">
                        <div v-if="showForm"  class="post-form ">
                            <PostForm v-model="showForm" @close="onCloseForm"/>
                        </div>
                    </transition >
                                
                </div>
                
                <div v-else class="d-inline-block  float-right">
                
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
</div>
   
</template>

<style type="text/css">
.fade-leave-active,.fade-enter-active{
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.nav-form { height: 50px; width: 100%; }
.post-form{
    /*位置情報?サイズ*/
    position: relative; 
    top: 60px;
    right: 0;
    /*left: 230px;*/
    z-index: 10;
    width: 400px; /* 幅 */
    padding: 10px;
    
    /*吹き出しボーダー*/
    border: solid #fff 2px;
    border-radius: 15px;
    
    background-color: white;
    
    /*影*/
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    border-radius: 10px;
    transition: 3s;
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
        onCloseForm(){
            console.log("closeForm")
            this.showForm = false
        },
    },
}
</script>