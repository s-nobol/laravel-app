<template>
<div>
        <h3>通報一覧</h3>
        
        
        <!--メッセージの一覧-->
        <div>
            <div v-for="report in reports" class="bg-white">
                <span>ID:{{ report.id }}</span>
                <span>件名:{{ report.title}}</span>
                <span>内容:{{ report.description}}</span>
                <button class="p-0 btn btn-danger" @click="deletereport(report.id)">削除</button>
            </div>
        </div>
</div>
</template>]
<script>

export default {
    data(){
        return{
            reportForm: {
                content: ''
            },
            reportErrors: null,
            reports: []
        }
    },
    methods:{
        
     
        async getreport(){
            const response = await axios.get(`/api/reports`)
            console.log("通報を受信",response)
            if( response.status === 200 ){
                this.reports = response.data
            }
        },
        async deletereport(id){
            const response = await axios.delete(`/api/reports/${ id }`)
            console.log("通報を削除受信", response)
            if( response.status === 200 ){
                console.log(response.data)
            }
        }
    },
    created(){
        this.getreport()
    }
}
</script>