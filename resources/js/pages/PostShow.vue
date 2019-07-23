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
            <div v-if="true" class="d-inline-block">
                <button class="btn btn-success" @click="Mode = ! Mode ">編集</button>
                <button class="btn btn-danger" @click="postDelete">削除</button>
            </div>
            
            <p v-if="Mode" class="text-success">編集モード</p>
            
            <div  v-if="! Mode">
                <span>タイトル: {{ post.title }}</span></br>
                <span>説明: {{ post.description }}</span></br>
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
        
        
        <div>
            <span>作成ユーザー</span>
        </div>
        
        
        <!--コメント-->
        <div class="mt-3">
            <h4><b>記事のコメント</b></h4>
        </div>
    </div>

</div>
</template>

<style type="text/css">
/*後で編集*/
input[type="text"] {
    border: none;
  border-bottom: 1px solid lightgray;
}
input[type="text"]:focus {
  outline: 0;
  border-bottom: 1px solid #ff9900;
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
            post: null,
            
        }
    },
    methods:{
    
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