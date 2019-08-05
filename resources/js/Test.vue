<template>
<div>

        <span @click="onClickButtonForm">吹き出しボタン</span>
        
        <button @click="onClickButtonErrors">エラーチェックボタン</button>
       
    
</div>
</template>


<script>
export default {

    data() {
        return {
            mause: false,
            form: false,
            user: {
                name: '123',
                email: '123@example.com',
                sex: 0,
                address: '住所',
                message: 'これはテストメッセージです',
            },
            id: 51//ログインユーザーのID
        }
    },
    methods:{
        onClickButtonErrors(){
           
            this.userEdit()
        },
        
        async userEdit(){
            // Route::put('/users/{user}/details', 'UserController@update2');
            // user-update-1
            console.log("送信", this.user )
            // const response = await axios.put(`/api/users/${this.id}` , this.user )
            
            //user-update-2
            const response = await axios.get(`/api/messages`, this.user )
            console.log(response)
        
            if(response.status !== 200){
                this.$store.commit('error/setCode', response.status)
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