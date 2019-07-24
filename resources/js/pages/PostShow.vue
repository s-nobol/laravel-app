<template>
<div class="text-center">
    <h1>PostShow.vue</h1>
    
    <div v-if="post">
    
        <!--画像-->
        <div class="">
            <img src="/image.jpg"></img>
        </div>
        
        <!--記事のステータス-->
        <div class="mt-3">
            <h4 class="d-inline-block">
                <b>記事のステータス</b>
                
            </h4>
            <div v-if="post.user_by_create" class="d-inline-block">
                <button class="btn btn-success" @click="Mode = ! Mode ">編集</button>
                <button class="btn btn-danger" @click="postDelete">削除</button>
            </div>
            
            <p v-if="Mode" class="text-success">編集モード</p>
            
            <div  v-if="! Mode">
                <h2>{{ post.title }}</h2>
                <small>{{ post.created_at}}</small></br>
                <span>{{ post.description }}</span></br>
            </div>
        </div>
        
        <!--編集モード時-->
        <div v-if="Mode" class="mt-3" >
            <form  @submit.prevent="editPost">
            
                <div class="mt-3 " >
                    <!--<label>{{ post.title }}</label></br>-->
                    <h3>{{ post.title }}</h3>
                    <input type="text" class=" bg-light " v-model="post.title" autofocus/>
                </div>
                
                <div class="mt-3" >
                    <!--<label>{{ post.description }}</label></br>-->
                    <h5>{{ post.description }}</h5>
                    <input type="text"  class="bg-light " v-model="post.description" />
                </div>
                
                <div class="mt-3" >
                    <input type="submit" value="Submit" class="btn btn-primary"/>
                </div>
            </form>
        </div>
        
        <!--いいねボタン-->
        <div class="mt-3 ">
            <button 
                class="btn"
                :class="{ ' btn-danger text-white' : post.user_by_liked }"
                @click="onClickLike">
                <i class="fas fa-heart mr-2 "></i>{{ post.likes_count}}
            </button>
        </div>
        
        <!--ホームボタン-->
        <!--<div class="mt-3"><i class="fas fa-home text-primary"></i></div>-->
        
        <!--通報ボタン-->
        <div class="mt-3"><span>通報する</span> </div>
        
        
        <button class="btn btn-dark mt-3">投稿者</button></br>
        
        <!--投稿者-->
        <div class="mt-3 bg-whitesmoke pt-3">
            
            <!--ユーザープロフィール-->
            <RouterLink :to="`/users/${post.user.id}`" >
                <img src="/noimage.jpg" style="width: 100px;"></img></br>
                <h3><b>{{ post.user.name }}</b></h3>
                <span class="text-dark"><i class="fas fa-map-marker-alt"></i>福岡県</span>
            </RouterLink>
            
        </div>
        
        
        <!--コメント-->
        <div class="mt-3">
            <button class="btn btn-dark mt-3">コメント</button></br>
        </div>
    </div>

</div>
</template>

<style type="text/css">
.bg-whitesmoke{
        background-color: whitesmoke;
}
/*後で編集*/
input[type="text"] {
    border: none;
  border-bottom: 1px solid lightgray;
}
input[type="text"]:focus {
  outline: 0;
  border-bottom: 1px solid #ff9900;
}

/*ダイアログ*/
/*#dialog {*/
/*    width: 250px;*/
/*    margin: auto;*/
/*    margin-top: 40vh;*/
/*    padding: 30px 20px;*/
/*    display: none;*/
/*    text-align: center;*/
/*    border: 1px solid #aaa;*/
/*    box-shadow: 2px 2px 4px #888;*/
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
            post: null,
            
        }
    },
    computed: {
        currentUser () {
            return this.$store.state.auth.user
        },
    },
    methods:{
        
        // post
        async getPost(){
            const response = await axios.get(`/api/posts/${ this.id }`)
            console.log("記事を一覧受信",response)
            if (response.status === 200) {
                this.post = response.data
            }
        },
        async editPost(){
            
            const response = await axios.put(`/api/posts/${ this.id }` , this.post )
            console.log("記事の編集を受信",response)
            if (response.status === 200) {
                this.post = response.data
            }
            this.Mode = false
            
        },
        async postDelete(){
             console.log("記事の削除")
            // const response = await axios.delete(`/api/posts/${ this.id }`)
            // console.log("記事を一覧受信",response)
            // if (response.status === 200) {
            //     this.post = response.data
            // }
        },
        
        // like
        onClickLike(){
            if(! this.currentUser){
                confirm("ログインしてください")
                return false
            }
            
            if(this.post.user_by_liked){
                this.unlike()
            }else{
                this.like()
            }
        },
        async like(){
            const response = await axios.put(`/api/posts/${ this.id }/like`)
            console.log("like", response)
            if (response.status === 200) {
                this.post.likes_count  = response.data.likes_count
                this.post.user_by_liked  = response.data.user_by_liked
            }
        },
        async unlike(){
            
            this.sending = true
            const response = await axios.delete(`/api/posts/${ this.id }/like`)
            console.log("unlike", response)
            if (response.status === 200) {
                this.post.likes_count  = response.data.likes_count
                this.post.user_by_liked  = response.data.user_by_liked
            }
            
        },
        
        
    },
    
    watch: {
        $route: { 
            async handler () {
                console.log("PostShow.vue表示")
                this.getPost()
            },
            immediate: true
        }
    }
    
}
</script>