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
            <!--<div v-if="tab === 0">-->
                
            <!--    <div v-if="user.posts.length > 0 " class="text-left">-->
            <!--        <div v-for="post in user.posts" class="d-inline-block">-->
            <!--            <RouterLink :to="`/posts/${post.token}`"  >-->
            <!--                <div>-->
            <!--                    <img src="/image.jpg" style="width: 200px"></img>-->
            <!--                </div>-->
            <!--            </RouterLink>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            
            <!--<div v-if="tab >  0 " >-->
                <div v-if="posts.length > 0 " class="text-left">
                
                    <transition-group name="list" tag="div">
                    <div v-for="post in posts" :key="post.id" class="d-inline-block">
                        <RouterLink :to="`/posts/${post.token}`"  >
                            <div>
                                <img src="/image.jpg" style="width: 200px"></img>
                            </div>
                        </RouterLink>
                    </div>
                    </transition-group>
                
                </div>
                
                
            <!--</div>-->
            
            <!--要素の最底辺-->
            <div id="imageButtom"class="mt-3 border-top" style="height: 500px;">
                <span>画像の最低ライン</span>
                <span v-if="loading" class="text-info">読み込み中</span>
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

.list-enter-active, .list-leave-active {
  transition: all 1.3s;
}
.list-enter, .list-leave-to /* .list-leave-active for below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
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
            loading: false,
            
            // ページネーション
            currentPage: 0,
            lastPage: 0,
            
            // スクロール
            scrollTop: 0,
            scrollBottom: null,
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
                            content: 'ユーザーを情報を編集しました',
                            type: 'user-edit',
                            timeout: 3000
                    })
                }
        },
        
        
        // タブの選択
        onChangeTab(select){
            if(this.tab !== select )
            { 
                this.tab = select
                this.resetPage()
                this.getPost()
            }
            return false
            
        },
        
        // すべての記事取得をまとめる
        async getPost(){
            // ローディング開始
            this.loading = true
            
            // ユーザーの記事
            if(this.tab === 0){ 
                var response = await axios.get(`/api/users/${ this.id }/posts?page=${this.currentPage + 1}`) 
            }
            // ユーザーのいいねした記事
            else if(this.tab === 1){ 
                var response = await axios.get(`/api/users/${ this.id }/likes?page=${this.currentPage + 1}`) 
            }
            // みんなの記事
            else if(this.tab === 2){ 
                var response = await axios.get(`/api/posts?page=${this.currentPage + 1}`)  
            }
            
            
            console.log("記事を受信", response)
            if (response.status === 200) {
                
                // ページの更新
                this.currentPage = response.data.current_page
                this.lastPage = response.data.last_page
                this.addPost(response.data)
            }
        },
        
        // 記事の追加
        addPost(reponse_data){
            var time = 0
            var num = 0
            var posts_count = reponse_data.data.length
            
            for (var i = 0; i < posts_count; i++) {
                time = time + 100
                setTimeout(()=>{
                    
                    // 記事をリストに追加
                    this.posts.push(reponse_data.data[num])
                    num += 1
    
                    
                    //記事の読み込み終了
                    if(num === posts_count){
                        this.getScrollButtom()
                        this.loading = false
                    }
                    
                }, time )
                
            }
        },
        
        handleScroll() {
            this.scrollTop = window.scrollY;
            if(this.scrollTop+500 > this.scrollBottom ){
                
                if(this.loading){
                    console.log("ローディング中", this.scrollBottom)
                    return false
                }
                
                this.getPost()
            }
        },
        
        //画像の最底辺取得
        getScrollButtom(){
            var imageButtom = document.getElementById("imageButtom")
            this.scrollBottom =  imageButtom.offsetTop;
        },
        
        // ページのリセット
        resetPage(){
            this.posts = []
            this.currentPage = 0
            this.lastPage = 0
        }
    },
    watch: {
        $route: { 
            async handler () {
                this.getUser()
                this.getPost()
                window.addEventListener('scroll', this.handleScroll); //スクロールイベント取得
            },
            immediate: true
        }
    }
    
}
</script>