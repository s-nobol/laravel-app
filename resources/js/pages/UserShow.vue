<template>
<div class="text-center">

    <div v-if="user" class="bg-white text-center">
    
        
        <!--プロフィール画像-->
        <div class=" pt-5">
            <div class="m-auto rounded-circle image-form" 
                style="width: 150px; height: 150px; overflow: hidden;" >
                
                <!--画像あり-->
                <img v-if="user.image"
                    :src="user.url"  
                    class="image "  
                    :class="{'image-hover' : imageHover }"
                    @mouseover="onHoverImage"  @mouseout="onDownImage"></img>
                
                <!--画像なし-->
                <img v-if="! user.image"
                    src="/noimage.jpg"  
                    class="image "  
                    :class="{'image-hover' : imageHover }"
                    @mouseover="onHoverImage"  @mouseout="onDownImage"></img>
            </div>
        </div>
        
        
        
        <!--ユーザーのステータス-->
        <div　v-if="true"  class="mt-3 pb-4 text-center">
            
            <div v-if="currentUser" class="">
                <div v-if="user.id === currentUser.id ">
                    <button class="btn btn-success" @click="Mode = ! Mode ">編集</button>
                </div>
            </div>
            
            
            <!--ユーザーステータス-->
            
            <!--名前-->
            <h4><b>{{ user.name }}</b></h4>
            
            <!--性別-->
            <h6 v-if="user.sex">
                <span v-if="user.sex == 1 "><b>男性</b></span>
                <span v-if="user.sex == 2 "><b>女性</b></span>
            </h6>
            
            <!--住所-->
            <h6 v-if="user.address">
                <b><i class="fas fa-map-marker-alt fa-lg  m-1"></i>{{ user.address }}</b>
            </h6>
            
            <!--一言-->
            <div v-if="user.message" class="m-auto w-25">
                <p class="break-word">{{ user.message }}</p>
            </div>
            
                
            <!--編集フォーム-->
            <transition name="slide_down">
            <div v-if="Mode" class=" user-form " >
                <form  @submit.prevent="editUser" class="m-auto border-top"  id="edit-form">
                
                    <!--エラーメッセージ-->
                    <div v-if="errors">
                      <p class="text-danger">入力に誤りがあります</p>
                    </div>
                    
                    <!--名前-->
                    <div class="mt-3" >
                        <b>名前</b></br>
                        <input type="text" class="border bg-light " v-model="user.name"  :class="{ 'border-danger' : errors }" />
                    </div>
                    
                    <!--性別-->
                    <div class="mt-3"  :class="{ 'text-danger' : errors }">
                        <b class="text-dark">性別</b></br>
                        男<input type="radio" name="sex" value="1" v-model="user.sex"  >
                        女<input type="radio" name="sex" value="2" v-model="user.sex"  >
                    </div>
                    
                    <!--住所-->
                    <div class="mt-3">
                        <b>住所</b></br>
                        <select name="pref" class="border bg-light p-1"  v-model="user.address"  :class="{ 'border-danger' : errors }">
                        <option value="">選択してください</option>
                        <option value="北海道">北海道</option>
                        <option value="青森県">青森県</option>
                        <option value="岩手県">岩手県</option>
                        <option value="宮城県">宮城県</option>
                        <option value="秋田県">秋田県</option>
                        <option value="山形県">山形県</option>
                        <option value="福島県">福島県</option>
                        <option value="茨城県">茨城県</option>
                        <option value="栃木県">栃木県</option>
                        <option value="群馬県">群馬県</option>
                        <option value="埼玉県">埼玉県</option>
                        <option value="千葉県">千葉県</option>
                        <option value="東京都" selected>東京都</option>
                        <option value="神奈川県">神奈川県</option>
                        <option value="新潟県">新潟県</option>
                        <option value="富山県">富山県</option>
                        <option value="石川県">石川県</option>
                        <option value="福井県">福井県</option>
                        <option value="山梨県">山梨県</option>
                        <option value="長野県">長野県</option>
                        <option value="岐阜県">岐阜県</option>
                        <option value="静岡県">静岡県</option>
                        <option value="愛知県">愛知県</option>
                        <option value="三重県">三重県</option>
                        <option value="滋賀県">滋賀県</option>
                        <option value="京都府">京都府</option>
                        <option value="大阪府">大阪府</option>
                        <option value="兵庫県">兵庫県</option>
                        <option value="奈良県">奈良県</option>
                        <option value="和歌山県">和歌山県</option>
                        <option value="鳥取県">鳥取県</option>
                        <option value="島根県">島根県</option>
                        <option value="岡山県">岡山県</option>
                        <option value="広島県">広島県</option>
                        <option value="山口県">山口県</option>
                        <option value="徳島県">徳島県</option>
                        <option value="香川県">香川県</option>
                        <option value="愛媛県">愛媛県</option>
                        <option value="高知県">高知県</option>
                        <option value="福岡県">福岡県</option>
                        <option value="佐賀県">佐賀県</option>
                        <option value="長崎県">長崎県</option>
                        <option value="熊本県">熊本県</option>
                        <option value="大分県">大分県</option>
                        <option value="宮崎県">宮崎県</option>
                        <option value="鹿児島県">鹿児島県</option>
                        <option value="沖縄県">沖縄県</option>
                        </select>
                    </div>
                    
                    
                    <div class="mt-3"> 
                        <RouterLink :to="`/users/${id}/edit`">詳細設定</RouterLink>
                    </div>
                        
                    <div class="mt-3" >
                        <input type="submit" value="Submit" class="btn btn-primary"/>
                    </div>
                </form>
                
            </div>
            </transition>
        </div>
            
            
            
        
        
        <!--記事の一覧-->
        <div class="mt-3">
            <div class="m-auto container pl-0 pr-0  row">
                
                <!--自分の写真-->
                <div 
                    class="w-30 tab-color" 
                    :class="{ 'tab-color-select' : tab === 0 }"
                    @click="onChangeTab(0)">
                    <h5 class="text-center p-2 mt-1" >自分の写真</h5>
                </div>
                
                <!--いいねした写真-->
                <div
                    class="w-30 tab-color" 
                    :class="{ 'tab-color-select' : tab === 1 }"
                    @click="onChangeTab(1)">
                    <h5 class="text-center p-2  mt-1">いいねした写真</h5>
                </div>
                
                <!--みんなの写真-->
                <div 
                    class="w-30  tab-color"
                    :class="{ 'tab-color-select ' : tab === 2 }"
                    @click="onChangeTab(2)">
                    <h5 class="text-center p-2 mt-1">みんなの写真</h5>
                </div>
            
            </div>
            
        
            <div v-if="posts.length > 0 " class="text-left bg-light" >
            
                <transition-group name="list" tag="div">
                <div  v-for="post in posts" :key="post.id"  id="postview"
                    class="d-inline-block p-1" style=" overflow: hidden;">
                    <RouterLink :to="`/posts/${post.token}`"  @mouseover.native="mouseover" >
                        <div class="post-image-form" >
                            <img v-if="post.image" :src="post.url+'thum.jpg'" 
                                style="width: 100%;" class="image" alt="画像がありません"></img>
                            <img v-else src="/image.jpg" style="width: 100%;" class="image"></img>
                        </div>
                    </RouterLink>
                </div>
                </transition-group>
            
            </div>
            
            <div v-if="posts.length === 0 " class="mt-5 pb-5">
                 <div class="m-auto w-rsp-25 p-3">
                    <div class="p-3 text-center card ">
                        <!--<span class="display-2"><b>403</b></span>-->
                        <!--<h4 class="border-bottom pb-3"><span><b>You Dont Have Post</b></span></h4>-->
                        <h5 class="pt-2"><span>まだ記事がありません</span></h5>
                    </div>
                </div>
            </div>
            
            
            <!--要素の最底辺-->
            <transition name="fade">
            <div v-if="this.currentPage < this.lastPage "  id="imageButtom"
                class="mt-3 border-top text-center " style="height: 500px;" >
                
                <span v-if="loading" class="text-info">読み込み中</span>
            </div>
            </transition>
            
           
        </div>
        
    </div>
</div>
</template>

<style type="text/css">
    
.user-form{
    height: 330px;
    /*overflow-y: auto;*/
    overflow: hidden;
}

/*タブの色*/
.w-30{
    width: 33%;
}

.list-enter-active, .list-leave-active {
  transition: all 1.5s;
}
.list-enter, .list-leave-to /* .list-leave-active for below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(60px);
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
            errors: null,
            imageHover: false,
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
                
                if(response.status !== 200){
                    this.$store.commit('error/setCode', response.status)
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
                    
                    //エラーメッセージのリセット
                    this.errors = null
                    this.Mode = false
                    return false
                }
                if(response.status === 422){
                    this.errors = response.data.errors
                }
                if(response.status !== 200){
                    this.$store.commit('error/setCode', response.status)
                }
        },
        
        mouseover(){},
        
        
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
                time = time + 300
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
                this.getUser()
                this.getPost()
                window.addEventListener('scroll', this.handleScroll); //スクロールイベント取得
            },
            immediate: true
        }
    }
    
}
</script>