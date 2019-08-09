<template>
    <div>
    
    
        <!--<h1>ホーム</h1>-->
        <div v-if="posts.length > 0">
        
            <transition-group name="list" tag="div">
            <div v-for="post in posts" :key="post.id" 
                class="d-inline-block p-1" style="width: 20%; overflow: hidden;" >
                
                <RouterLink :to="`/posts/${post.token}`" >
                    <div >
                        {{ post.id }}
                        <img v-if="post.image" :src="post.url+'thum.jpg'" 
                            style="width: 100%;" class="list-image" alt="画像がありません"></img>
                        <img v-else src="/image.jpg" style="width: 100%;" class="image"></img>
                    </div>
                </RouterLink>
                
            </div>
            </transition-group>
            
        </div>
        
        <!--要素の最底辺-->
        <div  id="imageButtom"class="mt-3 border-top text-center" style="height: 500px;"  >
            <span v-if="loading" class="text-info">読み込み中</span>
        </div>
    
    </div>

</template>


<style type="text/css">
.list-enter-active, .list-leave-active {
  transition: all 1.3s;
}
.list-enter, .list-leave-to /* .list-leave-active for below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
.buttom-h{
    height: 150px;
}
</style>


<script>

// import Modal from '../components/modal/Modal.vue'

export default {
    // components:{Modal},
    data(){
        return{
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
    methods:{
    
      
        
        async getPost(){
            
            // ローディング開始
            this.loading = true
            
            
            const response = await axios.get(`/api/posts?page=${this.currentPage+1}`)
            console.log("記事を一覧受信",response)
            
            // ページの更新
            this.currentPage = response.data.current_page
            this.lastPage = response.data.last_page
            
            // もしなら
            if(this.lastPage === this.currentPage){
                
            }
            
            var time = 0
            var num = 0
            var posts_count = response.data.data.length
            
            for (var i = 0; i < posts_count; i++) {
                time = time + 100
                setTimeout(()=>{
                    
                    // 記事をリストに追加
                    this.posts.push(response.data.data[num])
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
        //名前変更した方がいいかも？
        getScrollButtom(){
            var imageButtom = document.getElementById("imageButtom")
            this.scrollBottom =  imageButtom.offsetTop;
        },
    
    },
    watch: {
        $route: {
            async handler () {
                this.getPost()
                window.addEventListener('scroll', this.handleScroll); //スクロールイベント取得
                
            },
            immediate: true
        }
    }
    
}
</script>