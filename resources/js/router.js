import Vue from 'vue'
import VueRouter from 'vue-router'
// import store from './store' 

// ページコンポーネントをインポートする

import Home from './pages/Home.vue'
import NotFound from './pages/NotFound.vue'


import About from './pages/About.vue'
import Admin from './pages/Admin.vue'
import PostShow from './pages/PostShow.vue'
import UserShow from './pages/UserShow.vue'
import UserEdit from './pages/UserEdit.vue'
import PasswordReset from './pages/PasswordReset.vue'

import Test from './Test.vue'


// VueRouterプラグインを使用する
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  { path: '/', component: Home  },
  { path: '/posts', component: Home },
  { path: '/posts/:id',  component: PostShow, props: true },
  { path: '/users/:id',  component: UserShow, props: true },
  { path: '/users/:id/edit',  component: UserEdit, props: true },
  { path: '/about', component: About},
  { path: '/admin', component: Admin},
  { path: '/password_reset',  component: PasswordReset },
  { path: '/api/password/reset/:token',  component: PasswordReset, props: true },
  { path: '/test', component: Test},
  // {
  //   path: '/login', component: Login,
  //   beforeEnter (to, from, next) {
  //     if (store.getters['auth/check']) {
  //       next('/')
  //     } else {
  //       next()
  //     }
  //   }
  // },
  // { path: '/postscreate',  component: PostCreate, props: true },
  // { path: '/posts/:id/edit',  component: PostEdit, props: true  },
  // { path: '/500', component: SystemError },
  { path: '*',  component: NotFound }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history', 
  routes
})


export default router