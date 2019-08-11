<template>
<div  class="mt-5">

    <div v-if="post" class="text-center">

        <!--画像-->
        <div class="mt-5">
            
                <img v-if="post.image" :src="post.url+'image.jpg'" class="post-image"></img>
                <img v-else src="/image.jpg"  class="post-image"></img>
            
            <div v-if="currentUser" >
                <div v-if="post.user.id === currentUser.id">
                    <span class="text-success" @click="Mode = ! Mode " style="cursor: hand; cursor:pointer;">編集</span>
                    <span class="text-danger2" @click="postDelete" style="cursor: hand; cursor:pointer;">削除</span>
                </div>
            </div>
        </div>
        
        
        
        <!--記事のステータス-->
        <!--<div class="mt-3">-->
        <!--    <p v-if="Mode" class="text-success">編集モード</p>-->
        <!--</div>-->
        
        
        
        <!--カテゴリー-->
        <div class="mt-5 mb-3">
            <span class="p-2 bg-success2">{{ post.category.name }}</span>
        </div>
        
        
        
        <!--タイトル-->
        <h1 class="p-0 mt-3">{{ post.title }}</h1>
        <small class="text-muted">{{  post.created_at }}</small>
        
      
        
        <!--Postステータス-->
        <div class="mt-5 ">
        
            <!--コメント-->
            <button 
                class="btn  p-0 text-success2"
                @click="onClickComment"> 
                <i class="far fa-comment-alt fa-lg m-1 "></i>{{ post.comments_count}}
            </button>
            
            <!--View-->
            <span class="text-success2">
                <i class="far fa-eye fa-lg  m-1 "></i>0
            </span>
            
            <!--like-->
            <button 
                class="btn p-0 text-success2"
                :class="{ ' text-danger' : post.user_by_liked }"
                @click="onClickLike">
                 <i class="far fa-thumbs-up fa-lg m-1 "></i>{{ post.likes_count}}
            </button>
        </div>
        
        
        <!--説明-->
        <div  class="mt-5"  >
            <div class=" w-25 m-auto">
            <span>{{ post.description }}</span>
            </div>
        </div>
        
        
        <!--編集モード時-->
        <transition name="slide_down">
        <div v-if="Mode" class="mt-3 post-edit-form" >
            <form  @submit.prevent="editPost" class="m-auto border-top" id="edit-form">
                
                
                <!--エラーメッセージ-->
                <div v-if="errors">
                    <p class="text-danger">入力に誤りがあります</p>
                </div>
                
                <!--タイトル-->
                <div class="mt-3 " >
                    <h5>タイトル</h5>
                    <input type="text"  v-model="post.title"
                    class=" border bg-light w-100" :class="{ 'border-danger' : errors }"/>
                </div>
                
                <!--説明-->
                <div class="mt-3" >
                    <h5>説明</h5>
                    <textarea  rows="4"  v-model="post.description"
                    class=" border bg-light w-100" :class="{ 'border-danger' : errors }"></textarea>
                </div>
                
                <!--送信ボタン-->
                <div class="mt-3" >
                    <input type="submit" value="Submit" class="btn btn-primary"/>
                </div>
            </form>
        </div>
        </transition>
        
        
        <!--通報ボタン-->
        <div v-if="currentUser" class="mt-5 text-muted">
            <span @click="reportModal = ! reportModal">
                <i class="fas fa-exclamation-circle m-1"></i>通報する
            </span>
        </div>
        <transition name="fade" >
            <Report v-if="reportModal" :id="post.id" @close="onCloseReport"/>
        </transition>
        
        
        
        <!--投稿者-->
        <div class="mt-5 bg-whitesmoke p-5 ">
            
            <button class="btn bg-success2  mt-2 mb-3">投稿者</button></br>
            
            
            <!--ユーザープロフィール-->
            <RouterLink :to="`/users/${post.user.id}`"  class="" >
                  <div class="m-auto rounded-circle image-form" style="width: 120px; height: 120px; overflow: hidden;" >
                    
                    <!--画像あり-->
                    <img v-if="post.user.image"
                        :src="post.user.url"  
                        class="image "  
                        :class="{'image-hover' : imageHover }"
                        @mouseover="onHoverImage"  @mouseout="onDownImage"></img>
                    
                    <!--画像なし-->
                    <img v-if="! post.user.image"
                        src="/noimage.jpg"  
                        class="image "  
                        :class="{'image-hover' : imageHover }"
                        @mouseover="onHoverImage"  @mouseout="onDownImage"></img>
                </div>
                
                
                <h3 class="mt-2 text-post-edit2"><b>{{ post.user.name }}</b></h3>
                <span class="text-dark" v-if="post.user.address">
                    <i class="fas fa-map-marker-alt fa-lg  m-1"></i>{{ post.user.address }}
                </span>
            </RouterLink>
            
        </div>
        
        
        <!--コメント-->
        <div class="row mt-5 p-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button class="btn bg-success2 mt-3">コメント</button></br>
                <Comment :post="post" />
            </div>
            <div class="col-md-3"></div>
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

.post-image{
    max-width: 700px;
    max-height:  700px;
    /*width: 300px;*/
}
.post-edit-form{
    height: 300px;
    overflow: hidden;
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
            errors: null,
            reportModal: false,
            imageHover: false,
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
            if (response.status !== 200){
                this.$store.commit('error/setCode', response.status)
            }
        },
        async editPost(){
            
            const response = await axios.put(`/api/posts/${ this.post.id }` , this.post )
            
            console.log("記事の編集を受信",response)
            
            // バリテーションエラー
            if (response.status === 422){
                // alert(response.data.errors)
                this.errors = response.data.errors
                return false
            }
            
            // Update完了
            if (response.status === 200) {
                this.post = response.data 
                this.$store.commit('message/setContent', {   // メッセージ登録
                        content: '記事を編集しました',
                        type: 'success',
                        timeout: 3000
                })
                //エラーメッセージのリセット
                this.errors = ''
                this.Mode = false
                return false
            }
            
            
            // エラー
            if (response.status !== 200){
                this.$store.commit('error/setCode', response.status)
            }
            
        },
        async postDelete(){
            
            if(confirm("本当に削除しますか？")){
            }else{
                return false
            }
            console.log("記事の削除")
           
            const response = await axios.delete(`/api/posts/${ this.post.id }`)
            console.log("記事を一覧受信",response)
            if (response.status === 200) { 
                this.$store.commit('message/setContent', {   // メッセージ登録
                    content: '記事を削除しました',
                    type: 'danger',
                    timeout: 3000
                })
                this.$router.push(`/users/${this.post.user.id}`)
            }
            
            // エラー
            if (response.status !== 200){
                this.$store.commit('error/setCode', response.status)
            }
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
        
        // ユーザーマウスオーバー
        onHoverImage(){
            this.imageHover = true
        },
        onDownImage(){
            this.imageHover = false}
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