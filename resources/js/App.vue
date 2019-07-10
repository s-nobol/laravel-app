<template>
  <div>
      <h2 >App1-{{ title }}</h2>
      <div>
      <button @click="onChangeTitle" class="btn btn-primary">タイトル変更</button>
      </div>
  </div>
</template>

<script>

export default {
    created(){
        console.log("App.vue起動")
    },
    data(){
        return{
            title: "これが表示されれはVue.jsは起動している"
        }
    },
    methods:{
        onChangeTitle(){
            console.log("タイトルの変更")
            this.title ="Vue.jsによってタイトルが変更されました"
        }
    }
    
}
</script>