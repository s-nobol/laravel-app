<template>
<div>

        <span @click="onClickButtonForm">吹き出しボタン</span>
        
        <button @click="onClickButtonErrors">エラーチェックボタン</button>
        <div class="w-25 bg-danger">吹き出し
            <div v-if="form" class="">
            <!--吹き出し-->
                <div  class="postForm bg-white">
                    <span>これは吹き出し</span>
                </div>
            </div>
        </div>
    
</div>
</template>

<style type="text/css">
.postForm{
    
    /*位置情報?サイズ*/
    position:  relative; 
    top: 15px;
    right: 50px;
    z-index: 1;
    width: 200px; /* 幅 */
    padding: 10px;
    
    /*吹き出しボーダー*/
    border: solid #fff 2px;
    border-radius: 15px;
    
    background-color: white;
    
    /*影*/
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    border-radius: 2px;
    transition: 3s;
} 
</style>

<script>
export default {

    data() {
        return {
            mause: false,
            form: false
        }
    },
    methods:{
        onClickButtonErrors(){
            // this.$store.commit('error/setCode', 404)
            this.$store.commit('error/setCode', 500)
            // this.$store.commit('error/setCode', 401)
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