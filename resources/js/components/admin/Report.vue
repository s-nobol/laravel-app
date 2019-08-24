<template>
<div>
        
       
        
        <!--メッセージの一覧-->
        <div class="mt-3">
            <h3 class="d-inline-block">通報一覧</h3>
            <!--<button class="btn btn-danger p-0" @click="deleteAll">クリア</button>-->
            
         
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">件名</th>
                        <th scope="col">内容</th>
                        <th scope="col">記事のID</th>
                        <th scope="col">削除</th>
                    </tr>
                </thead>
                
                <tbody v-for="report in reports"  :key="report.id">
                    <tr>
                        <th scope="row">{{ report.id }}</th>
                        <td><p class="text-over">{{ report.title }}</p></td>
                        <td><p class="text-over p-0 m-0"  @mouseover.native="mouseover">{{ report.description }}</p></td>
                        
                        <!--送信ボタン-->
                        <td>
                            <div v-if="report.post">
                                <RouterLink :to="`/posts/${report.post.token}`">{{ report.post.token }}...へ移動する</RouterLink>
                                <span @click="deletePost(report.post.id)" class="pointer text-danger" >delete</span>
                            </div>
                            
                            <div v-if="! report.post">
                                <span class="pointer text-danger">削除済み</span>
                            </div>
                        </td>
                        
                        <!--通報削除ボタン-->
                        <td>
                            <button class="btn btn-danger" @click="deleteReport(report)">削除</button>
                        </td>
                
                    </tr>
                </tbody>
            </table>
            
            <!--もっと読むボタン-->
            <div class="text-center">
                <button 
                    v-if="currentPage !== lastPage "
                    class="btn btn-success"  
                    @click="getReport"
                    >もっと読む</button>
            </div>
        </div>
</div>
</template>
<script>

export default {
    data(){
        return{
            reportForm: {
                content: ''
            },
            reportErrors: null,
            reports: [],
            
            // ページネーション
            currentPage: 0,
            lastPage: 0,
            
            loading: false,
            
            reportHover: false
        }
    },
    methods:{
        
        
        async getReport(){
            
            
            if(this.loading){ return false } //読み込み中ならcancel
            this.loading = true
            
            const response = await axios.get(`/api/admin/get_report?page=${this.currentPage+1}`)
            console.log("通報を受信",response)
            if( response.status === 200 ){
                
                const report_count = response.data.data.length
                for (var i = 0; i < report_count; i++) {
                    this.reports.push(response.data.data[i])
                }  
            
                // ページの更新
                this.currentPage = response.data.current_page
                this.lastPage = response.data.last_page
            }
            
            this.loading = false
        },
        async deleteReport(item){
            
            const response = await axios.delete(`/api/reports/${ item.id }`)
            console.log("通報を削除受信", response)
            if( response.status === 200 ){
                console.log(response.data)
                
                var index = this.reports.indexOf(item)
                this.reports.splice(index, 1);
                this.$store.commit('message/setContent', {
                    content: '通報を削除しました',
                    type: 'danger',
                    timeout: 3000
                })
                    
            }
        },
        async deleteAll(){
            const response = await axios.delete(`/api/reports/${ id }`)
            console.log("通報を削除受信", response)
            if( response.status === 200 ){
                console.log(response.data)
            }
        },
        
        // 記事の削除
        async deletePost(id){
            if(confirm("記事を削除しますか？ "+ id)){ 
                const response = await axios.delete(`/api/admin/delete_post/${ id }`)
                console.log("通報を削除受信", response)
                if( response.status === 200 ){
                    console.log(response.data)
                    const msg = response.data
                    this.$store.commit('message/setContent', {
                        content: msg,
                        type: 'danger',
                        timeout: 3000
                    })
                    
                }
                
            }
        },
        
        mouseover(){ alert("dsdsd")}
        
    },
    
    created(){
        this.getReport()
    }
}
</script>