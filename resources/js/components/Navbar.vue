<template>
<div class="" >
    <nav class="navbar bg-white nav-form border-bottom " >
    
        <div class="m-auto container  ">
                <RouterLink class="navbar-brand text-dark " to="/">
                    <b>Laravel-app</b>
                </RouterLink>
                
                <div v-if="currentUser" class=" float-right">
                
                    <ul class="nav justify-content-end">
                        
                        <li class="nav-item mr-2"  style="position: relative; ">
                            <button  class=" btn btn-primary" @click="showForm = ! showForm" >記事の作成</button>
                        </li>
                        
                        <li class="nav-item " id="navbar-user" >
                            <RouterLink class="navbar-brand" :to="`/users/${currentUser.id}`">
                            
                            <!--画像あり-->
                            <img v-if="currentUser.image"
                                :src="currentUser.url"
                                style="width: 30px; height: 30px; " 
                                class="image rounded-circle d-inline-block align-top"></img>
                            
                            <!--画像なし-->
                            <img v-if="! currentUser.image"
                                src="/noimage.jpg"  
                                style="width: 30px; height: 30px; " 
                                class="image rounded-circle " ></img>
                            
                            
                            
                                <small v-if="currentUser" class="text-dark" >{{ currentUser.name }}</small>
                            </RouterLink>
                        </li>
                        
                        <li class="navbar-brand " id="navbar-user" style="cursor: hand; cursor:pointer;">
                            <small v-if="currentUser" @click="logout"  class="text-dark" >ログアウト</small>
                        </li>
                        <li class="nav-item " id="navbar-menu">
                            <!--<a href="#" class="">-->
                                <i class="fas fa-bars navbar-brand pl-2" @click="menuBar = ! menuBar" ></i>
                            <!--</a>-->
                        </li>
                        
                    
                    </ul>
               
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
    
     
    
    <!--記事投稿画面-->
    <transition name="slide_down">
        <div v-if="menuBar" class="navbar-menu-item bg-white" id="navbar-menu" >
            <div v-if="currentUser" class=" container p-1">
                <div class="p-2 border-bottom"> 
                <RouterLink class="navbar-brand" :to="`/users/${currentUser.id}`">
                    
                    <!--画像あり-->
                    <img v-if="currentUser.image"
                        :src="currentUser.url"
                        style="width: 30px; height: 30px; " 
                        class="image rounded-circle d-inline-block align-top"></img>
                    
                    <!--画像なし-->
                    <img v-if="! currentUser.image"
                        src="/noimage.jpg"  
                        style="width: 30px; height: 30px; " 
                        class="image rounded-circle " ></img>
                    
                    
                    
                        <small v-if="currentUser" class="text-dark" >{{ currentUser.name }}</small>
                    </RouterLink>
                </div>
                <div class="p-2">     
                        <small v-if="currentUser" @click="logout" class="navbar-brand text-dark" 
                        style="cursor: hand; cursor:pointer;">ログアウト</small>
                </div>
            </div>
        </div>
    </transition >
    
    <!--モーダル-->
    <transition name="fade" >
        <Modal v-if="modal" :modal="modal" @close="onCloseModal" />
    </transition >
</div>
   
</template>

<style type="text/css">
.nav-form { height: 50px; width: 100%; }
/*.post-form{*/
    /*位置情報?サイズ*/
    /*position: relative; */
/*    position: absolute; */
/*    top: 60px;*/
/*    right: 15%;*/
    /*left: 0;*/
/*    z-index: 10;*/
    width: 400px; /* 幅 */
/*    padding: 10px;*/
    
    /*吹き出しボーダー*/
/*    border: solid #fff 2px;*/
/*    border-radius: 15px;*/
    
/*    background-color: white;*/
    
    /*影*/
/*    box-shadow: 0 3px 6px rgba(0,0,0,0.1);*/
/*    border-radius: 10px;*/
/*    transition: 3s;*/
/*}*/

.menu{
    background-color: white;
    width: 100%; 
    height: 50px; 
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
            isActive: false,//
            modal: false,
            showForm: false,
            menuBar: false,
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
            this.menuBar = false
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