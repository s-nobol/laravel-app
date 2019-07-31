<template>
<div class="text-center">

    <h1>UserEdit.vue</h1>
    <div v-if="user" class="bg-white">
    
        <div class="text-right p-2">
            <!--<button class="btn btn-secondary">戻る</button>-->
            <RouterLink :to="`/users/${ user.id }`" class="btn btn-secondary">戻る</RouterLink>
        </div>
        
        <h3>ユーザーの詳細な設定</h3>
            
        <!--画像-->
        <div class="text-center">
            <div class="m-auto">
            <img src="/noimage.jpg" style="width: 100px;" class="rounded-circle mt-5"></img>
            </div>
        </div>
        
        <form  @submit.prevent="onChangeUser">
            
            <!--エラーメッセージ-->
            <div v-if="errors" class="errors text-danger mt-2">
                <ul v-if="errors.email">
                    <li v-for="msg in errors.email" :key="msg">メールアドレス{{ msg }}</li>
                </ul>
                <ul v-if="errors.sex">
                    <li v-for="msg in errors.sex" :key="msg">性別{{ msg }}</li>
                </ul>
                <ul v-if="errors.birthday">
                    <li v-for="msg in errors.birthday" :key="msg">誕生日{{ msg }}</li>
                </ul>
                <ul v-if="errors.address">
                    <li v-for="msg in errors.address" :key="msg">住所{{ msg }}</li>
                </ul>
                <ul v-if="errors.message">
                    <li v-for="msg in errors.message" :key="msg">一言{{ msg }}</li>
                </ul>
            </div>
        
        
        
            <div class="mt-3">
                <label for="">名前</label></br>
                <input type="text" v-model="user.name"/>
            </div>
            <div class="mt-3">
                <label for="">メールアドレス</label></br>
                <input type="text"  v-model="user.email"/>
            </div>
            
            <div class="mt-3">
                <label for="">性別</label></br>
                男<input type="radio" name="sex" value="0" v-model="user.sex">
                女<input type="radio" name="sex" value="1" v-model="user.sex">
            </div>
            
            <div class="mt-3">
                <label for="">生年月日</label></br>
                <select name="year">
                <option value="">-</option>
                <option value="1936">1936</option>
                <option value="1937">1937</option>
                <option value="1938">1938</option>
                <option value="1939">1939</option>
                <option value="1940">1940</option>
                <option value="1941">1941</option>
                <option value="1942">1942</option>
                <option value="1943">1943</option>
                <option value="1944">1944</option>
                <option value="1945">1945</option>
                <option value="1946">1946</option>
                <option value="1947">1947</option>
                <option value="1948">1948</option>
                <option value="1949">1949</option>
                <option value="1950">1950</option>
                <option value="1951">1951</option>
                <option value="1952">1952</option>
                <option value="1953">1953</option>
                <option value="1954">1954</option>
                <option value="1955">1955</option>
                <option value="1956">1956</option>
                <option value="1957">1957</option>
                <option value="1958">1958</option>
                <option value="1959">1959</option>
                <option value="1960">1960</option>
                <option value="1961">1961</option>
                <option value="1962">1962</option>
                <option value="1963">1963</option>
                <option value="1964">1964</option>
                <option value="1965">1965</option>
                <option value="1966">1966</option>
                <option value="1967">1967</option>
                <option value="1968">1968</option>
                <option value="1969">1969</option>
                <option value="1970">1970</option>
                <option value="1971">1971</option>
                <option value="1972">1972</option>
                <option value="1973">1973</option>
                <option value="1974">1974</option>
                <option value="1975">1975</option>
                <option value="1976">1976</option>
                <option value="1977">1977</option>
                <option value="1978">1978</option>
                <option value="1979">1979</option>
                <option value="1980">1980</option>
                <option value="1981">1981</option>
                <option value="1982">1982</option>
                <option value="1983">1983</option>
                <option value="1984">1984</option>
                <option value="1985">1985</option>
                <option value="1986">1986</option>
                <option value="1987">1987</option>
                <option value="1988">1988</option>
                <option value="1989">1989</option>
                <option value="1990">1990</option>
                <option value="1991">1991</option>
                <option value="1992">1992</option>
                <option value="1993">1993</option>
                <option value="1994">1994</option>
                <option value="1995">1995</option>
                <option value="1996">1996</option>
                <option value="1997">1997</option>
                <option value="1998">1998</option>
                <option value="1999">1999</option>
                <option value="2000">2000</option>
                <option value="2001">2001</option>
                <option value="2002">2002</option>
                <option value="2003">2003</option>
                <option value="2004">2004</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                </select>年
                <select name="month">
                <option value="">-</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select>月
                <select name="day">
                <option value="">-</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                </select>日
            </div>
            <div class="mt-3">
                <label for="">住所</label></br>
                <select name="pref"  v-model="user.address">
                <option value="">選択してください</option>
                <option value="北海道">北海道</option>
                <option value="青森県">青森県</option>
                <option value="岩手県">岩手県</option>
                <option value="宮城県">宮城県</option>
                <option value="秋田県">秋田県</option>
                <option value="山形県">山形県</option>
                <option value="福島県">福島県</option>
                <option value="茨城県">茨城県</option>
                <option value="栃木県">栃木県</option>
                <option value="群馬県">群馬県</option>
                <option value="埼玉県">埼玉県</option>
                <option value="千葉県">千葉県</option>
                <option value="東京都" selected>東京都</option>
                <option value="神奈川県">神奈川県</option>
                <option value="新潟県">新潟県</option>
                <option value="富山県">富山県</option>
                <option value="石川県">石川県</option>
                <option value="福井県">福井県</option>
                <option value="山梨県">山梨県</option>
                <option value="長野県">長野県</option>
                <option value="岐阜県">岐阜県</option>
                <option value="静岡県">静岡県</option>
                <option value="愛知県">愛知県</option>
                <option value="三重県">三重県</option>
                <option value="滋賀県">滋賀県</option>
                <option value="京都府">京都府</option>
                <option value="大阪府">大阪府</option>
                <option value="兵庫県">兵庫県</option>
                <option value="奈良県">奈良県</option>
                <option value="和歌山県">和歌山県</option>
                <option value="鳥取県">鳥取県</option>
                <option value="島根県">島根県</option>
                <option value="岡山県">岡山県</option>
                <option value="広島県">広島県</option>
                <option value="山口県">山口県</option>
                <option value="徳島県">徳島県</option>
                <option value="香川県">香川県</option>
                <option value="愛媛県">愛媛県</option>
                <option value="高知県">高知県</option>
                <option value="福岡県">福岡県</option>
                <option value="佐賀県">佐賀県</option>
                <option value="長崎県">長崎県</option>
                <option value="熊本県">熊本県</option>
                <option value="大分県">大分県</option>
                <option value="宮崎県">宮崎県</option>
                <option value="鹿児島県">鹿児島県</option>
                <option value="沖縄県">沖縄県</option>
                </select>
            </div>
            <div class="mt-3">
                <label for="">一言</label></br>
                <textarea rows="4" v-model="user.message"
                class="form-control border p-1"></textarea>
                                 
            </div>
            
            <div>
                <input type="submit" value="Submit"/>
            </div>
        </form>
        
        
    </div>
</div>
</template>

<script>
// import Modal from '../components/modal/Modal.vue'

export default {
    // components:{Modal},
    props: {
        id:{
            type: String,
            required: true
        }
    },
    data(){
        return{
            user: null,
            errors: null
        }
    },
    computed: {
        currentUser () {
            return this.$store.getters['auth/currentUser']
        },
    },
    methods:{
        
        //ユーザー情報
        async getEditUser(){
                console.log("ユーザーID",this.id)
                const response = await axios.get(`/api/users/${ this.id }/edit`)
                console.log("ユーザーを受信",response)
                if (response.status === 200) {
                    this.user = response.data
                    // this.posts =response.data.posts 
                }
        },
        async onChangeUser(){
                console.log("ユーザー情報を送信", this.user )
                const response = await axios.put(`/api/users/${ this.id }/details`, this.user)
                console.log("ユーザーを受信",response)
                if (response.status === 200) {
                    // this.$store.commit('message/setContent', {   // メッセージ登録
                    //         content: 'ユーザーを編集しました',
                    //         type: 'success',
                    //         timeout: 3000
                    // })
                }
                if(response.status === 422 ){
                    this.errors = response.data.errors
                }
        },
        
    },
    watch: {
        $route: { 
            async handler () {
                this.getEditUser()
            },
            immediate: true
        }
    }
}
</script>