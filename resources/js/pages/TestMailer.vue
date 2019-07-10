<template>
<div>
<h3>メール送信ページ</h3>

<button @click="sendEmail">メールを送信する</button>
</div>

</template>

<script>
export default{
    
    created(){
        console.log("メール送信ページ表示")
    },
    methods:{
        async sendEmail(){
        console.log("メール送信")
        
        const response = await axios.post('/api/sendemail')
        
        console.log("メール受信", response)
        if (response.status === OK) {
            return false
        }
        
        }
    }
}
</script>