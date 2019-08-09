<template>
<div v-show="value" class="">

    <div v-if="currentUser">
    
        <form class="mt-2"  @submit.prevent="createPost">
                     
       
            <!--画像フォーム-->
            <div v-if="errors" class="w-100">
                <div v-if="errors.image">
                    <!--<span v-for="msg in errors.image" class="text-danger">{{ msg }}</span>-->
                    <p class="text-danger ">アップロードできませんでした。画像が大きすぎる可能性があります</p>
                </div>
            </div>
            
            <div v-if="! preview " class="dashed text-center bg-light"  style="height: 250px; width: 380px; "
                @click="imageForm"
                @dragleave.prevent @dragover.prevent @drop.prevent="onDrop">
                
                <p class="mt-5 text-white"><i class="far fa-image fa-7x"></i></p>
                <p class="mt-2">
                    <span>画像ファイルを選択してください</span></br>
                    <span>ドラックアンドドロップも可能です</span>
                </p>
                
                <input type="file" class="w-100 bg-danger h-100 " style="display:none;"
                    id="input-file" @change="onFileChange"/>
            </div>
            
            <!--プレビュー-->
            <div v-if="preview">
                <img :src="preview" alt="" style="max-height: 400px; max-width: 100%;" >
            </div>
            
            <transition name="slide_down">
            <div v-if="preview" class="post-input-form">
            
                <div v-if="errors">
                        <!--タブ・カテゴリーなど-->
                        <div class="mt-2"> 
                                <span v-if="errors.category"  class="text-danger">カテゴリーを選択してください</span>
                            
                                <label v-if="! errors.category" label for="">カテゴリー</label>
                            
                            
                            <select name="" v-model="category">
                            <option v-for="item in categorys" :value="item.id">{{ item.name }}</option>
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
                            <select name="" v-model="category">
                            <option v-for="item in categorys" :value="item.id">{{ item.name }}</option>
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
                    <!--<input  value="送信" class="btn btn-primary"/>-->
        
                    <button　class="btn btn-primary" @click="onPostUpload">
                        <span v-if="loading" class="spinner-grow spinner-grow-sm"></span>
                        <span v-if="loading">アップロード中です</span>
                        <span v-if="! loading">作成する</span>
                    
                    </button>
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
            categorys: [],
            category: 1,
            title: '',
            description: '',
            errors: null,
            
            loading: false,
            acd: false
        }
    },
    computed: {
        currentUser () {
            return this.$store.getters['auth/currentUser']
        },
    },
    methods: {
        // カテゴリー取得
        async getCategory(){
            const response = await axios.get('/api/categorys')
            console.log("カテゴリー取得", response)
            if (response.status === 200) {
                this.categorys = response.data
            }
        },
        
        async createPost(){
            
            if(this.loading){
                console.log("loagin中です")
                return false
            }
            this.loading = true
            
            const formData = new FormData()
            formData.append('image', this.image)
            formData.append('category_id', Number(this.category))
            formData.append('title', this.title)
            formData.append('description', this.description )
            
            
            const response = await axios.post('/api/posts', formData)
            console.log("記事の作成受信", response)
            if (response.status === 201) {
                // メッセージ登録
                this.$store.commit('message/setContent', {
                        content: '写真が投稿されました！',
                        type: 'success',
                        timeout: 3000
                })
                this.$emit('close')
                this.reset()
                return false
            }
            // バリテーションエラー
            if (response.status === 422) {
                this.errors = response.data.errors
                
                if(this.errors.image){
                    this.reset()
                }
            }
            
            this.loading = false
            
        },
        
        onPostUpload(){
            // console.log("起動")
        },
        // 画面アップロード
        imageForm(){
            // 画像フォームがクリックされればinput起動
            document.getElementById('input-file').click();
        },
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
            this.getCategory() //カテゴリーの取得
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
                
                this.getCategory() //カテゴリーの取得
        },
        reset () {
            this.preview = ''
            this.image = null
            this.$el.querySelector('input[type="file"]').value = null
        }
    
    },
    created(){
        // this.getCategory()
        console.log("Postform起動" )
    },
    destroyed(){
        console.log("Postform終了")
    }
    
  
}
</script>

