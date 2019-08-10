<template>
<div>

        <div class="all-wrapper">
            <div class="dropdown-wrapper" @click="isActive = !isActive">
                <div class="dropdown-text">メニュ</div>
                <i class="el-icon-caret-bottom"></i>
            </div>
            <div class="list-items" v-if="isActive">
               
                    <div class="list-item">
                        選択肢がありません
                    </div>
            </div>
        </div>
        <div class="dropdown-bg" @click="isActive = false" v-if="isActive">15</div>
</div>
</template>
<style type="text/css">
/*#postview{*/
/*    background-color: gray;*/
/*}*/

</style>


<script>
export default {

    data() {
        return {
            isActive: false, 
            preview: null,
            image2: null,
            mause: false,
            form: false,
        }
    },
    methods:{
        // SendImage(){
        // },
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