<template>
<div>

    <div class="container">
        <form  @submit.prevent="SendImage" >
        
            <input type="file" name="" @change="onFileChange"/>
            <div v-if="preview">
                <img :src="preview" style="max-height: 500px;"></img>
            </div>
            
            <div class="mt-3">
                <input type="submit" value="Submit" class="btn btn-primary"/>
            </div>
        </form>
        <!--<button @click="onClickButtonErrors" >エラーチェックボタン</button>-->
    </div>
       
    
</div>
</template>


<script>
export default {

    data() {
        return {
            preview: null,
            image2: null,
            mause: false,
            form: false,
        }
    },
    methods:{
        // SendImage(){
        // },
        
        // 画面アップロード
        onFileChange (event) {
            if(event.target.files.length === 0 && ! event.target.files[0].type.match('image.*')) {
                // this.reset()
                return false
            }
            
            const reader = new FileReader()
            reader.onload = e => {
                this.preview = e.target.result
            }
            reader.readAsDataURL(event.target.files[0])
            this.image2 = event.target.files[0]
        },
        
        
         async SendImage(){
            
            const formData = new FormData()
            formData.append('image', this.image2)
            // formData.append('name', "これはテストメッセージです")
            
            
            const response = await axios.post(`/api/users/51/image`, formData)
            console.log("ユーザーを受信",response)
            if (response.status === 201) {
                // メッセージ登録
                this.$store.commit('message/setContent', {
                        content: '写真が投稿されました！',
                        type: 'success',
                        timeout: 3000
                })
                // this.$emit('close')
                this.reset()
                return false
            }
            // バリテーションエラー
            if (response.status === 422) {
                this.errors = response.data.errors
            }
            
        },
        onClickButtonForm(){
            this.form = ! this.form
            console.log("form",this.form)
        },
    //   hoverImage(){}
    }, 
    
}

// </script1>


// <script1>
// リストを一つずつ表示
// <transition-group name="list" tag="span">
//     <span v-for="(item, index) in items" 
//           v-bind:key="item"
//           v-bind:data-index="index" class="list-item">
//          {{ item }}
//     </span>
// </transition-group >
// var time = 0
// for ( var i=1; i < this.list.length; i++ ) {
//     time = time + 100
//     setTimeout(()=>{
//         this.items.push(list[i])
//     }, time )
// }

// 画像の拡大
// <div class="image-form">
// <img 
//     src="/noimage.jpg"  
//     style="width: 150px;"
//     class="image"
//     :class="{ 'image-hover': mause }"
//     @mouseover="hoverImage()"
//     @mouseout="downImage()"
//     ></img>
//     <div class="hover">123</div>
// </div>

// .image-form{
//     width: 150px;
//     height: 150px;
//     overflow: hidden;
// }
// .image{
//     transition-duration: 0.5s;
//     width: 150px;
//     height: 150px;
//     overflow: hidden;
// }
// .image-hover{
//     transform: scale(1.2);
//     transition-duration: 0.5s;
//     overflow: hidden;
// }
// data() {
//     return {
//         mause: false
//     }
// },
</script>