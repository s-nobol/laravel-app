<template>
<div class="text-center">

    <h1>UserShow.vue</h1>
    <!--<h3>{{ user.id }}:::{{ currentUser.id}}</h3>-->
    
    <div v-if="user" class="bg-white">
    
        
        <!--画像-->
        <div class="text-center">
            <img src="/noimage.jpg" style="width: 150px;" class="rounded-circle mt-5"></img>
        </div>
        
        
        
        <!--ユーザーのステータス-->
        <div　v-if="true"  class="mt-3 text-center">
            
            <div v-if="currentUser" class="">
                <div v-if="user.id === currentUser.id ">
                    <button class="btn btn-success" @click="Mode = ! Mode ">編集</button>
                </div>
            </div>
            
            <h4><b>{{ user.name }}</b></h4>
            <!--<h6><b>メールアドレス:{{ user.email }}</b></h6>-->
            <h6><b>男性</b></h6>
            <h6><b>住所:福岡</b></h6>
        </div>
        
        
        
        <!--編集フォーム-->
        <transition name="slide_down">
        <div v-if="Mode" class=" user-form" >
            <form  @submit.prevent="editUser">
            
                <div class="mt-3" >
                    <h4>名前</h4>
                    <input type="text" class=" bg-light " v-model="user.name" autofocus/>
                </div>
                
                <div class="mt-3" >
                    <h5>メールアドレス</h5>
                    <input type="text"  class="bg-light " v-model="user.email " />
                </div>
                
                <!--<RouterLink to="/password_reset">パスワードの変更</RouterLink>-->
                <RouterLink :to="`/users/${id}/edit`">詳細設定</RouterLink>
                    
                <div class="mt-3" >
                    <input type="submit" value="Submit" class="btn btn-primary"/>
                </div>
            </form>
            
        </div>
        </transition>
        
        
        <!--記事の一覧-->
        <div class="mt-5">
            <div class="row m-0">
            
                <!--自分の写真-->
                <div 
                    class="col-4 bg-primary" 
                    :class="{ 'bg-white ' : tab === 0 }"
                    @click="onChangeTab(0)">
                    <h5 class="text-center p-2" >自分の写真</h5>
                </div>
                
                <!--いいねした写真-->
                <div
                    class="col-4  bg-primary" 
                    :class="{ 'bg-white ' : tab === 1 }"
                    @click="onChangeTab(1)">
                    <h5 class="text-center p-2">いいねした写真</h5>
                </div>
                
                <!--みんなの写真-->
                <div 
                    class="col-4  bg-primary"
                    :class="{ 'bg-white ' : tab === 2 }"
                    @click="onChangeTab(2)">
                    <h5 class="text-center p-2">みんなの写真</h5>
                </div>
            </div>
            
            <!--タブテーブル-->
            <div v-if="tab === 0">
                <div v-if="user.posts.length > 0 " class="text-left">
                    <div v-for="post in user.posts" class="d-inline-block">
                        <RouterLink :to="`/posts/${post.token}`"  >
                            <div>
                                <img src="/image.jpg" style="width: 200px"></img>
                            </div>
                        </RouterLink>
                    </div>
                </div>
            </div>
            
            <div v-if="tab >  0 " >
                <!--<h2>ユーザー写真以外</h2>-->
                <div v-if="posts.length > 0 " class="text-left">
                    <div v-for="post in posts" class="d-inline-block">
                        <RouterLink :to="`/posts/${post.token}`"  >
                            <div>
                                <img src="/image.jpg" style="width: 200px"></img>
                            </div>
                        </RouterLink>
                    </div>
                </div>
            </div>
            
           
        </div>
        
    </div>
</div>
</template>

<style type="text/css">
    
.user-form{
    height: 200px;
    /*overflow-y: auto;*/
    overflow: hidden;
}

/*.slide_down-enter-active, .slide_down-leave-active {*/
/*    transition: all .5s;*/
/*}*/
/*.slide_down-enter, .slide_down-leave-to {*/
/*    height: 0;*/
/*}*/
</style>

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
            tab: 0,
            posts: [],
        }
    },
    computed: {
        currentUser () {
            return this.$store.getters['auth/currentUser']
        },
    },
    methods:{
        
        //ユーザー情報
        async getUser(){
                console.log("ユーザーID",this.id)
                const response = await axios.get(`/api/users/${ this.id }`)
                console.log("ユーザーを受信",response)
                if (response.status === 200) {
                    this.user = response.data
                    // this.posts =response.data.posts 
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
        
        
        // タブの選択
        onChangeTab(num){
            this.tab = num
            if (num === 1) {
                this.getLikePost()
            }else if (num === 2 ) {
                this.getOtherPost()
            }
        },
        
        //ユーザーがいいねを押した記事
        async getLikePost(){
            console.log("id",this.id)
                const response = await axios.get(`/api/users/${ this.id }/likes`)
                console.log("like記事を受信",response)
                if (response.status === 200) {
                    this.posts = response.data
                }
        },
        
        //みんなの記事
        async getOtherPost(){
                const response = await axios.get(`/api/posts`)
                console.log("記事を受信",response)
                if (response.status === 200) {
                    this.posts = response.data
                }
        },
    },
    watch: {
        $route: { 
            async handler () {
                this.getUser()
            },
            immediate: true
        }
    }
    
}
</script>