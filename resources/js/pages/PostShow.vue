<template>
<div class="text-center">
    <h1>PostShow.vue</h1>
    
    <div v-if="post">
    
        <!--画像-->
        <div class="">
            <img src="/image.jpg"></img>
        </div>
        
        
        <!--記事のステータス-->
        <div class="">
        
            <h4 class="d-inline-block">
                <!--<b>記事のステータス</b>-->
            </h4>
            
            <div v-if="currentUser" class="d-inline-block">
                <div v-if="post.user.id === currentUser.id">
                    <button class="btn btn-success" @click="Mode = ! Mode ">編集</button>
                    <button class="btn btn-danger" @click="postDelete">削除</button>
                </div>
            </div>
            
            <p v-if="Mode" class="text-success">編集モード</p>
            
        </div>
        
        
        <!--タイトル-->
        <h1 class="p-0 m-0">{{ post.title }}</h1>
        <small class="text-dark">{{  post.created_at }}</small>
        
        
        <!--Postステータス-->
        <div class="mt-5 ">
        
            <!--コメント-->
            <button 
                class="btn  p-0"
                @click="onClickComment"> 
                <i class="far fa-comment-alt fa-lg m-1 "></i>54
            </button>
            
            <!--View-->
            <i class="far fa-eye fa-lg  m-1 "></i>1781
            
            <!--like-->
            <button 
                class="btn p-0"
                :class="{ ' text-danger' : post.user_by_liked }"
                @click="onClickLike">
                 <i class="far fa-thumbs-up fa-lg m-1 "></i>26{{ post.likes_count}}
            </button>
        </div>
        
        
        <!--説明-->
        <div  class="mt-5"  >
            <div class="text-dark w-25 m-auto">
            <span>{{ post.description }}</span>
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
        <div class="mt-5 ">
            <!--<button -->
            <!--    class="btn"-->
            <!--    :class="{ ' btn-danger text-white' : post.user_by_liked }"-->
            <!--    @click="onClickLike">-->
            <!--    <i class="fas fa-heart mr-2 "></i>{{ post.likes_count}}-->
            <!--</button>-->
        </div>
        
        
        
        <!--通報ボタン-->
        <div v-if="currentUser" class="mt-5">
            <span @click="reportModal = ! reportModal"><i class="fas fa-exclamation-circle m-1"></i>通報する</span>
        </div>
        <transition name="fade" >
            <Report v-if="reportModal" :id="post.id" @close="onCloseReport"/>
        </transition>
        
        
        <!--投稿者-->
        <button class="btn btn-dark mt-3">投稿者</button></br>
        
        <div class="mt-3 bg-whitesmoke pt-3 ">
            
            <!--ユーザープロフィール-->
            <RouterLink :to="`/users/${post.user.id}`" >
                <img src="/noimage.jpg" style="width: 100px;" class="rounded-circle imgWrap"></img></br>
                <h3><b>{{ post.user.name }}</b></h3>
                <span class="text-dark"><i class="fas fa-map-marker-alt fa-lg  m-1"></i>福岡県</span>
            </RouterLink>
            
        </div>
        
        
        <!--コメント-->
        <div class="mt-3">
            <button class="btn btn-dark mt-3">コメント</button></br>
            <Comment :post="post" />
        </div>
        
        
        
    </div>
</div>
</template>

<style type="text/css">
.bg-whitesmoke{
        background-color: whitesmoke;
}
.fade-leave-active,.fade-enter-active{
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}


</style>

<script>

import Comment from '../components/Comment.vue'
import Report from '../components/modal/Report.vue'
// import Modal from '../components/modal/Modal.vue'

export default {
    components:{
        Comment, Report
        // Modal,
        },
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
            reportModal: false
        }
    },
    computed: {
        currentUser () {
            return this.$store.getters['auth/currentUser']
        },
    },
    methods:{
        
        // post
        async getPost(){
            const response = await axios.get(`/api/posts/${ this.id }/view`)
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
                this.$store.commit('message/setContent', {   // メッセージ登録
                        content: '記事を編集しました',
                        type: 'success',
                        timeout: 3000
                })
            }
            this.Mode = false
            
        },
        async postDelete(){
            console.log("記事の削除")
            this.$store.commit('message/setContent', {   // メッセージ登録
                content: '記事を削除しました',
                type: 'danger',
                timeout: 3000
            })
            // const response = await axios.delete(`/api/posts/${ this.id }`)
            // console.log("記事を一覧受信",response)
            // if (response.status === 200) {
            //     this.post = response.data
            // }
        },
        
        //Comment
        onClickComment(){},
        
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
            const response = await axios.put(`/api/posts/${ this.post.id }/like`)
            console.log("like", response)
            if (response.status === 200) {
                this.post.likes_count  = response.data.likes_count
                this.post.user_by_liked  = response.data.user_by_liked
            }
        },
        async unlike(){
            
            this.sending = true
            const response = await axios.delete(`/api/posts/${ this.post.id }/like`)
            console.log("unlike", response)
            if (response.status === 200) {
                this.post.likes_count  = response.data.likes_count
                this.post.user_by_liked  = response.data.user_by_liked
            }
            
        },
        
        //通報ボタン
        async onReport(){
            // this.reportModal = true
        },
        onCloseReport() {
            console.log("通報する閉じる")
            this.reportModal = false
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