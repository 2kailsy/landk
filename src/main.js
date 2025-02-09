import Vue from 'vue'
import App from './App.vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import './assets/css/reset.css'
import 'font-awesome/css/font-awesome.min.css'
import service from './service'
import router from './router'
import dispatchEventStroage from '@/utils/tool'

Vue.use(ElementUI)

Vue.config.productionTip = false
Vue.prototype.service = service
Vue.use(dispatchEventStroage);

//路由守卫
router.beforeEach((to, from, next)=>{next();})

let admin=new Vue({
  router,
  render: h => h(App),
}).$mount('#app')

export default admin;
