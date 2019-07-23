<template>
<div>
    <h1>UserShow.vue</h1>

    <div>
    
        <!--画像-->
        <div class="text-center">
            <img src="/image.jpg" style="width: 150px;"></img>
        </div>
        
        <!--ユーザーのステータス-->
        <div class="mt-3 text-center">
            <h4><b>ユーザーのステータス</b></h4>
            <span>タイトル:</span><br>
            <span>説明:</span><br>
        </div>
        
        
        
        <!--コメント-->
        <div class="mt-3">
        </div>
    </div>
</div>
</template>

<script>

// import Modal from '../components/modal/Modal.vue'

export default {
    // components:{Modal},
    data(){
        return{
            posts: null,
        }
    },
    methods:{
         async getUser(){
                const response = await axios.get(`/api/users/${ this.id }`)
                console.log("記事を一覧受信",response)
                if (response.status === 200) {
                    this.posts = response.data
                }
        },
        
    
    },
    
    watch: {
        $route: { 
            async handler () {
                console.log("UserShow.vue表示")
            },
            immediate: true
        }
    }
    
}
</script>