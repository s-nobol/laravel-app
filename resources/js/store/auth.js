import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null
}

const getters = {
  currentUser:  state => state.user ? state.user : null,
  check: state => !! state.user,
  username: state => state.user ? state.user.name : ''
}

const mutations = {
    
  setUser (state, user) {
    state.user = user
  },
  
  setApiStatus (state, status) {
    state.apiStatus = status
  },
  
  setLoginErrorMessages (state, messages) {
    state.loginErrorMessages = messages
  },
  
  setRegisterErrorMessages (state, messages) {
    state.registerErrorMessages = messages
  }
}

const actions = {
  // 会員登録
  async register (context, data) {
      
    console.log("store-register送信")
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/register', data)
    console.log("store-register受信",response)
    
    if (response.status === CREATED) {
        
        context.commit('setApiStatus', true)
        context.commit('setUser', response.data)
        return false
    }

    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
        
        console.log("バリテーションエラー",response)
        context.commit('setRegisterErrorMessages', response.data.errors)
    } else {
        // エラーコード
        context.commit('error/setMessage', response.data.message, { root: true })
        context.commit('error/setCode', response.status, { root: true })
    }
  },

  // ログイン
  async login (context, data) {
    console.log("store-Login送信")
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/login', data)
    console.log("store-login受信",response)

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', response.data)
      return false
    }

    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
        console.log("バリテーションエラー",response)
        context.commit('setLoginErrorMessages', response.data.errors)
    } else {
      
        // エラーコード
        context.commit('error/setMessage', response.data.message, { root: true })
        context.commit('error/setCode', response.status, { root: true })
    }
  },

  // ログアウト
  async logout (context) {
    console.log("store-Loout送信")
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')

    console.log("store-Loout受信")
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', null)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },

  // ログインユーザーチェック
  async currentUser (context) {
    context.commit('setApiStatus', null)
    const response = await axios.get('/api/user')
    const user = response.data || null

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', user)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}

