<template>
<div>
    <div class=" frash1">
        <div class="p-3">これはアラートメッセージです</div>
    </div>
    
    <div class="frash2">
        <div class="p-3">これはアラートメッセージです</div>
    </div>
    
    <div class="frash3">
        <div class="p-3">これはアラートメッセージです</div>
    </div>
    <div class="frash4">
        <div class="p-3">これはアラートメッセージです</div>
    </div>
    
    
</div>
</template>
<style type="text/css">
.frash1{
    color: white;
    background-color: #5bd1d7;
}
.frash2{
    color: white;
    background-color: #348498;
}
.frash3{
    color: white;
    background-color: #ff502f;
}.frash4{
    color: #348498;
    background-color: #F4F4F4;
}
/*#f5ede1*/
</style>

<script>
export default {

    data() {
        return {
            mause: false
        }
    },
    methods:{
        hoverImage(){}
    }, 
    
}


</script>


<script>
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