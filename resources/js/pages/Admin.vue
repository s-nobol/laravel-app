<template>
<div>
    <div  v-if="admin" class=" container">
    
        <h1 class="mt-3 mb-3">管理者ページ</h1>
        
        <div class="row">
            
            <!--メニュ-->
            <div class="col-3 bg-white p-3">
                <p class="pointer" :class="{ 'text-primary' : tab === 0}" @click="tab = 0">メニュー</p>
                <p class="pointer" :class="{ 'text-primary' : tab === 1}" @click="tab = 1">データベース</p>
                <p class="pointer" :class="{ 'text-primary' : tab === 2}" @click="tab = 2">メッセージの作成</p>
                <p class="pointer" :class="{ 'text-primary' : tab === 3}" @click="tab = 3">通報</p>
            </div>
            
            <!--view-->
            <div class="col-9 bg-white p-3">
            
                <!--タブ1-->
                <div v-if=" tab === 0">
                    <h3>メニュー</h3>
                </div>
                
                <!--タブ2-->
                <div v-if=" tab === 1">
                    <DataBase />
                </div>
                
                
                <!--タブ3-->
                <div v-if=" tab === 2">
                    <Message />
                </div>
                
                <!--タブ4-->
                <div v-if=" tab === 3">
                    <Report />
                </div>
                
            </div>
        </div>
    
    </div>
    
    

</div>
</template>

<script>

import DataBase from '../components/admin/DataBase.vue'
import Message from '../components/admin/Message.vue'
import Report from '../components/admin/Report.vue'

export default {
    components:{ DataBase, Message, Report },
    data(){
        return{
            admin: false,
            tab: 3,
            posts: null,
            messageForm: {
                content: ''
            },
            messageErrors: null,
            messages: []
        }
    },
    methods:{
        
        // 管理者ユーザーか確認
        async getAdminUser(){
            
            const response = await axios.get(`/api/messages`)
            console.log("記事を一覧受信",response)
            if( response.status === 200 ){
                this.admin  = true
                return false;
            }
            if (response.status !== 200){
                this.$store.commit('error/setCode', response.status)
                return false
            }
        },
        
        
        //メッセージの作成
        async addMessage(){
            console.log("",this.messageForm)
            const response = await axios.post(`/api/messages`, this.messageForm)
            console.log("記事を一覧受信",response)
            // this.tab.length
            if( response.status === 201 ){
                this.messageForm.content = ''
            }else if ( response.status === 422 ){
                this.messageErrors = response.data.errors
                console.log(response.data.errors)
            }
        },
        async getMessage(){
            const response = await axios.get(`/api/messages`)
            console.log("記事を一覧受信",response)
            if( response.status === 200 ){
                this.messages = response.data
            }
        },
    },
    
    created(){
        this.getAdminUser()
    }
}
</script>