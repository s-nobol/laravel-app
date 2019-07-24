<template>
<div>
        <h3>メッセージの作成</h3>
        <form  @submit.prevent="addMessage" class="w-75">
            
            <!--エラーメッセージ-->
            <div v-if="messageErrors" class="text-danger">
                <ul v-if="messageErrors.content">
                    <li v-for="msg in messageErrors.content" :key="msg">{{ msg }}</li>
                </ul>
            </div>
            
            
            <div>
                <textarea v-model="messageForm.content" 
                placeholder="メッセージの入力" class="w-100" rows="6" ></textarea>
            </div>
            <div class="text-right">
                <input type="submit" value="送信" class="btn btn-primary"/>
            </div>
                
        </form>
        
        <!--メッセージの一覧-->
        <div>
            <div v-for="message in messages" class="bg-white">
                <span>ID:{{ message.id }}</span>
                <span>内容:{{ message.content}}</span>
                <button class="p-0 btn btn-danger" @click="deleteMessage(message.id)">削除</button>
            </div>
        </div>
</div>
</template>]
<script>

export default {
    data(){
        return{
            messageForm: {
                content: ''
            },
            messageErrors: null,
            messages: []
        }
    },
    methods:{
        
        //メッセージの作成
        async addMessage(){
            console.log("",this.messageForm)
            const response = await axios.post(`/api/messages`, this.messageForm)
            console.log("記事を一覧受信",response)
            // this.tab.length
            if( response.status === 201 ){
                this.messageForm.content = ''
            }else if ( response.status === 422 ){
                this.messageErrors = response.data.errors
                console.log(response.data.errors)
            }
        },
        async getMessage(){
            const response = await axios.get(`/api/messages`)
            console.log("記事を一覧受信",response)
            if( response.status === 200 ){
                this.messages = response.data
            }
        },
        async deleteMessage(id){
            const response = await axios.delete(`/api/messages/${ id }`)
            console.log("記事を一覧受信", response)
            if( response.status === 200 ){
                console.log(response.data)
            }
        }
    },
    created(){
        this.getMessage()
    }
}
</script>