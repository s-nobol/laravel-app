<template>

<div>
    
    <h2>システムエラーが発生しました</h2>
    <div v-if="getMessage">
        <p>エラー内容</p>
        <h4 class="test-danger" >{{ getMessage }}</h4>
        
    </div>
</div>
</template>

<script>

export default{
    computed:{
        getMessage(){
            return this.$store.state.error.message
        }
    }    
    
}

</script>