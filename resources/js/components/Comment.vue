<template>
<div class="mt-2 mb-5  w-75 m-auto">
    
    
    <!--コメント送信フォーム(ゲストユーザー用)-->
    <div v-if="! currentUser">
        <div>
            <p class="mt-3 border-bottom">ログインユーザーしかコメントはできません</p>
        </div>
    </div>
    
    <!--コメント送信フォーム(ログインユーザー用)-->
    <div v-if="currentUser" class="mt-3" >
        <form @submit.prevent="addComment">
            
            <!--コメントエラー-->
            <div v-if="commentErrors">
                <div v-if="commentErrors.content" class="text-danger">
                    <span v-for="msg in commentErrors.content" :key="msg">{{ msg }}</span>
                </div>
            </div>
        
            <!--コメント内容-->
            <textarea class="form-control" rows="3"  v-model="commentContent"
            :class="{ 'border border-danger' : commentErrors }"></textarea>
            
            <!--コメントボタン-->
            <div class="text-right mt-3">
                <input type="submit" value="送信" class="btn btn-primary"/>
            </div>
            
        </form>
    </div>
    
    
    
    
    <!--コメント一覧-->
    <div v-if="comments.length > 0" >
        <!--<b>コメント一覧</b></br>-->
        
        <div v-for="comment in comments"  class="mt-2">
        
            <div class="media">
            
                <!--非作成ユーザー-->
                <img v-if="comment.id !== post.user.id" src="/noimage.jpg" class="ml-3" alt="" style="width: 50px;">
                <div class="media-body text-left bg-whitesmoke p-3 pl-4 rounded-pill">
                    <div>
                        <!--<small>ユーザー名:{{ comment.user.name }}</small>-->
                        <!--<small>作成時間:{{ comment.created_at }}</small>-->
                    </div>
                    
                    <span>{{ comment.id }} {{ comment.content }}</span>
                </div>
                
                <!--記事作成ユーザー-->
                <img v-if="comment.id === post.user.id" src="/noimage.jpg" class="mr-3" alt="" style="width: 50px;">
                <div v-if="currentUser">
                <button
                    v-if="comment.user.id === currentUser.id"
                    class="btn btn-danger p-1" 
                    @click="deleteComment(comment)" 
                    >削除</button>
                </div>
            </div>
            
            
        </div>
        
        <!--ページネーション-->
        <div v-if="lastPage > 1" >
            <button @click="onPrev" class="btn btn-primary">前へ</button>
            <button @click="onNext" class="btn btn-primary">次へ</button>
        </div>
    </div>
  
    
</div>
</template>


<script>

export default {
    props:{
        post:{
            type: Object,
            required: true 
        }
    },
    data () {
        return {
            comments: [],
            commentContent: '',
            commentErrors: null,
            
            currentPage: 0,
            lastPage: 0
        }
    }, 
    computed: {
        currentUser () {
            return this.$store.getters['auth/currentUser']
        },
    },
    methods: {
        async getComment(){
            console.log("コメント受信", this.post.id)
            console.log("コメントページ", this.currentPage)
            
            const response = await axios.get(`/api/posts/${this.post.id}/comments?page=${this.currentPage}`)
            console.log("コメント受信",response)
            if(response.status === 200 ){
                this.comments = response.data.data
                this.currentPage = response.data.current_page
                this.lastPage = response.data.last_page
              
            }
        },
        async addComment(){
            if(! this.currentUser){
                confirm("ログインしていません")
                return false
            }
            
            const data = {content: this.commentContent, post_id: this.post.id }
            const response = await axios.post(`/api/posts/${this.post.id}/comments`,data)
            
            console.log("コメント送信受信",response)
            if (response.status === 422) {
                this.commentErrors = response.data.errors
                return false
            }
            if (response.status !== 201) {
                this.$store.commit('error/setCode', response.status)
                return false
            } 
            if (response.status === 201){
                this.comments.push({
                    id: response.data.id,
                    content:  response.data.content,
                    created_at: response.data.created_at,
                    user: this.currentUser
                })
                this.commentContent = ""
            }
        },
        async deleteComment(item){
            if(alert('削除しますか？?', item)){}
            console.log("コメント削除受信", item)
            
            const response = await axios.delete(`/api/posts/${item.id}/comments`)
            console.log("コメント削除受信",response)
            if (response.status !== 200) {
                if(alert('コメントが削除できませんでした')){}
                // this.$store.commit('error/setCode', response.status)
                return false
            }
            
            if(response.status === 200){
    			var index = this.comments.indexOf(item)
                this.comments.splice(index, 1);
                this.$store.commit('message/setContent', {  // メッセージ登録
                        content: 'コメントを削除しました',
                        type: 'danger',
                        timeout: 3000
                })
            }
            
        },
        
        
        // ページネーション
        onNext(){
            this.currentPage += 1
            console.log("page-next", this.currentPage )
            this.getComment()
        },
        onPrev(){
            this.currentPage -=1
            console.log("page-prev", this.currentPage )
            this.getComment()
        },
    },
    created(){
        this.getComment()
    },
}
</script>