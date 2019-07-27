<template>
<div class="text-center">

    <h1>UserShow.vue</h1>
    <!--<h3>{{ user.id }}:::{{ currentUser.id}}</h3>-->
    
    <div v-if="user">
    
        
        <!--画像-->
        <div class="text-center">
            <img src="/noimage.jpg" style="width: 150px;"></img>
        </div>
        
        
        
        <!--ユーザーのステータス-->
        <div　v-if="true"  class="mt-3 text-center">
            <h4><b>ユーザーのステータス</b></h4>
            
            <div v-if="currentUser" class="">
                <div v-if="user.id === currentUser.id ">
                    <button class="btn btn-success" @click="Mode = ! Mode ">編集</button>
                </div>
            </div>
            
            <span>ユーザー名:{{ user.name}}</span><br>
            <span>メールアドレス:{{ user.email }}</span><br>
        </div>
        
        
        
        <!--編集フォーム-->
        <div v-if="Mode" class="mt-3 " >
            <form  @submit.prevent="editUser">
            
                <div class="mt-3 " >
                    <!--<label>{{ user.title }}</label></br>-->
                    <h3>{{ user.name}}</h3>
                    <input type="text" class=" bg-light " v-model="user.name" autofocus/>
                </div>
                
                <div class="mt-3" >
                    <!--<label>{{ user.description }}</label></br>-->
                    <h5>{{ user.email  }}</h5>
                    <input type="text"  class="bg-light " v-model="user.email " />
                </div>
                
                <RouterLink to="/password_reset">パスワードの変更</RouterLink>
                    
                <div class="mt-3" >
                    <input type="submit" value="Submit" class="btn btn-primary"/>
                </div>
            </form>
            
        </div>
        
        
    </div>
</div>
</template>


<script>
// import Modal from '../components/modal/Modal.vue'

export default {
    // components:{Modal},
    props: {
        id:{
            type: String,
            required: true
        }
    },
    data(){
        return{
            Mode: false,
            user: null,
        }
    },
    methods:{
         async getUser(){
                console.log("ユーザーID",this.id)
                const response = await axios.get(`/api/users/${ this.id }/view`)
                console.log("ユーザーを受信",response)
                if (response.status === 200) {
                    this.user = response.data
                }
        },
         async editUser(){
                console.log("ユーザー情報を送信", this.user )
                const response = await axios.put(`/api/users/${ this.id }`, this.user)
                console.log("ユーザーを受信",response)
                if (response.status === 200) {
                    this.user = response.data
                   
                    this.$store.commit('message/setContent', {   // メッセージ登録
                            content: 'ユーザーを編集しました',
                            type: 'success',
                            timeout: 3000
                    })
                }
        },
    },
    computed: {
        currentUser () {
            return this.$store.getters['auth/currentUser']
        },
    },
    created(){
        // this.getUser()
    },
    watch: {
        $route: { 
            async handler () {
                console.log("UserShow.vue表示")
                this.getUser()
            },
            immediate: true
        }
    }
    
}
</script>