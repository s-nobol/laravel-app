import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store' 

// ページコンポーネントをインポートする
import PhotoList from './pages/PhotoList.vue'
import Login from './pages/Login.vue'
import TestMailer from './pages/TestMailer.vue'
import SystemError from './pages/errors/System.vue'
import NotFound from './pages/errors/NotFound.vue'

// VueRouterプラグインを使用する
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: PhotoList
  },
  {
    path: '/login',
    component: Login,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next('/')
      } else {
        next()
      }
    }
  },
  { path: '/500', component: SystemError },
  { path: '/testmailer',  component: TestMailer },
  { path: '*',  component: NotFound }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history', // ★ 追加
  routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router