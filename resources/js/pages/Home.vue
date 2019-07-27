<template>
    <div>
        <h1>Home.vue</h1>
        
        
        <div>
            <div v-for="post in posts" class="d-inline-block">
                <RouterLink :to="`/posts/${post.token}`"  >
                    <div>
                        <img src="/image.jpg" style="width: 200px"></img>
                    </div>
                </RouterLink>
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
    
        async getPost(){
            const response = await axios.get(`/api/posts`)
            console.log("記事を一覧受信",response)
            this.posts = response.data
        },
        
    
    },
    
    watch: {
        $route: {
            async handler () {
                await this.getPost()
            },
            immediate: true
        }
    }
    
    }
</script>