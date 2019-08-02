<template>
<div v-show="value" class="">

    <div v-if="currentUser">
    
        <form class="mt-2"  @submit.prevent="createPost">
                     
       
            <!--画像フォーム-->
            <div v-if="! preview "class="dashed text-center"  style="height: 250px; width: 380px;"
                @dragleave.prevent @dragover.prevent @drop.prevent="onDrop">
                <input type="file" class="p-3 " @change="onFileChange"/>
            </div>
            
            <!--プレビュー-->
            <div v-if="preview">
                <img :src="preview" alt="" style="height: 200px;" >
            </div>
            
            <transition name="slide_down">
            <div v-if="preview" class="post-input-form">
            
                <div v-if="errors">
                        <!--タブ・カテゴリーなど-->
                        <div class="mt-2">
                            <label for="">カテゴリー</label>
                            <select name="" id="">
                            <option value="123">123</option>
                            <option value="123">12,k,j3</option>
                            </select>
                        </div>
                        
                        
                        <!--タイトル-->
                        <div class="mt-2">
                            
                            <div v-if="errors.title">
                                <span v-for="msg in errors.title" class="text-danger">タイトル{{ msg }}</span>
                            </div>
                            <div v-if="! errors.title">
                                <label label for="">タイトル</label></br>
                            </div>
                            
                            <input type="text" 
                                class="w-100" :class="{ 'border border-danger' : errors.title }"
                                v-model="title" />
                        </div>
                        
                        <!--説明-->
                        <div class="mt-2">
                            <div v-if="errors.description ">
                                <span v-for="msg in errors.description"  class="text-danger">説明{{ msg }}</span>
                            </div>
                            <div v-if="! errors.description ">
                                <label label for="">説明</label></br>
                            </div>
                            
                            <textarea  rows="4" v-model="description"
                            class="w-100":class="{ 'border border-danger' : errors.description }" 
                            ></textarea>
                        </div>
                </div>
                
                
                <div v-if="! errors" >
                        <!--タブ・カテゴリーなど-->
                        <div class="mt-2">
                            <label for="">カテゴリー</label>
                            <select name="" id="">
                            <option value="123">123</option>
                            <option value="123">12,k,j3</option>
                            </select>
                        </div>
                        
                        
                        <!--タイトル-->
                        <div class="mt-2">
                            <label for="">タイトル</label></br>
                            <input type="text" class="w-100" v-model="title"/>
                        </div>
                        
                        <!--説明-->
                        <div class="mt-2">
                            <label for="">説明</label></br>
                            <textarea  rows="4" class="w-100" v-model="description"></textarea>
                        </div>
                </div>
                
                
                <!--送信ボタン-->
                <div class="mt-2 text-right">
                    <input type="submit" value="送信" class="btn btn-primary"/>
                </div>
            
            </div>
            </transition>
            
        </form>
                
    </div>
    
</div>
</template>
<style type="text/css">
.dashed{
    border: 2px dashed gray;
}

.post-input-form{
    height: 300px;
    overflow: hidden;
}
.slide_down-enter-active, .slide_down-leave-active {
    transition: all .5s;
}
.slide_down-enter, .slide_down-leave-to {
    height: 0;
}

</style>
<script>
export default {
    props: {
        value: {
            type: Boolean,
            required: true
        }
    },
    data(){
        return{
            image: null,
            preview: null,
            title: '',
            description: '',
            errors: null,
            
            acd: false
        }
    },
    computed: {
        currentUser () {
            return this.$store.getters['auth/currentUser']
        },
    },
    methods: {
        
        async createPost(){
            
            const formData = new FormData()
            formData.append('image', this.image)
            formData.append('title', this.title)
            formData.append('description', this.description )
            console.log("記事の作成送信", formData)
            
            const response = await axios.post('/api/posts', formData)
            if (response.status === 201) {
                // メッセージ登録
                this.$store.commit('message/setContent', {
                        content: '写真が投稿されました！',
                        type: 'success',
                        timeout: 3000
                })
                this.reset()
                this.$emit('input', false)
                return false
            }
            // バリテーションエラー
            if (response.status === 422) {
                this.errors = response.data.errors
            }
        },
        
        // 画面アップロード
        onFileChange (event) {
            if(event.target.files.length === 0 && ! event.target.files[0].type.match('image.*')) {
                this.reset()
                return false
            }
            
            const reader = new FileReader()
            reader.onload = e => {
                this.preview = e.target.result
            }
            reader.readAsDataURL(event.target.files[0])
            this.image = event.target.files[0]
        },
        
        // ドラックアンドドロップ
        onDrop: function(event){

                if(event.dataTransfer.files.length > 1 ){
                    console.log("ファイルは一つまでです")
                    return false
                }
                
                if( ! event.dataTransfer.files[0].type.match('image.*')) {
                    console.log("画像ファイルではありません")
                    this.reset()
                    return false
                }
                    
                const reader = new FileReader()
                reader.onload = e => {
                    this.preview = e.target.result
                }
                
                reader.readAsDataURL(event.dataTransfer.files[0])
                this.image = event.dataTransfer.files[0]
        },
        reset () {
            this.preview = ''
            this.image = null
            this.$el.querySelector('input[type="file"]').value = null
        }
    
    },
    created(){
        console.log("Postform起動")
    },
    destroyed(){
        console.log("Postform終了")
    }
    
  
}
</script>

