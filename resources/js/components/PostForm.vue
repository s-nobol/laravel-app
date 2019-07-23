<template>
<div v-show="value" class=" bg-white">
    <div class="container">
    
        <form class="mt-3"  @submit.prevent="createPost">
            <h3>PostFrom</h3>
            
                <!--画像フォーム-->
                <div v-if="! preview "class="dashed" @dragleave.prevent @dragover.prevent @drop.prevent="onDrop">
                    <input type="file" class="p-3" @change="onFileChange"/>
                </div>
                
                <!--プレビュー-->
                <div v-if="preview">
                    <img :src="preview" alt="">
                </div>
                
                <!--タイトル-->
                <div class="mt-3">
                    <label for="">タイトル</label></br>
                    <input type="text" v-model="title"/>
                </div>
                
                <!--説明-->
                <div class="mt-3">
                    <label for="">説明</label></br>
                    <input type="text" v-model="description"/>
                </div>
                
                <!--タブ・カテゴリーなど-->
                
                <!--送信ボタン-->
                <div class="mt-3">
                    <input type="submit" value="送信" class="btn btn-primary"/>
                </div>
                
        </form>
    </div>
</div>
</template>
<style type="text/css">
.dashed{
    border: 2px dashed gray;
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
            description: ''
        }
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
                this.items = response.data
            }
            this.reset()
            this.$emit('input', false)
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
    }
  
}
</script>

