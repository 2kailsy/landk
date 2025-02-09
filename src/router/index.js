import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [{
        path: '/',
        name: '主页',
        redirect: '/login',
        hidden: true,
        component: ()=> import('@/components/Home.vue')
    },{
        path: '/login',
        name: '登录',
        hidden: true,
        component: ()=> import('@/components/Login.vue')
    },{
        path: '*',
        name: '404页面',
        hidden: true,
        component: ()=> import('@/components/404.vue')
    },{
        path: '/home',
        name: '后台管理',
        icon: 'el-icon-star-off',
        redirect: '/home/webManage',
        component: ()=> import('@/components/Home.vue'),
        children: [{
            path: '/home/webManage',
            name: '网站管理',
            component: ()=> import('@/components/dataPage/WebAdmin.vue')
        },{
            path: '/home/question',
            name: '问题',
            component: ()=> import('@/components/dataPage/Question.vue')
        },{
            path: '/home/guess',
            name: '猜猜',
            component: ()=> import('@/components/dataPage/Guess.vue')
        },{
            path: '/home/sayMe',
            name: '留言',
            component: ()=> import('@/components/dataPage/SayMe.vue')
        },{
            path: '/home/about',
            name: '搜索',
            component: ()=> import('@/components/dataPage/About.vue')
        },{
            path: '/home/paper',
            name: '小纸条',
            component: ()=> import('@/components/dataPage/Paper.vue')
        },{
            path: '/home/says',
            name: '她说',
            component: ()=> import('@/components/dataPage/Says.vue')
        },{
            path: '/home/saysTH',
            name: '对她说',
            component: ()=> import('@/components/dataPage/SaysTH.vue')
        },{
            path: '/home/sign',
            name: '签到',
            component: ()=> import('@/components/dataPage/Sign.vue')
        }]
    },{
        path: '/setting',
        icon: 'el-icon-setting',
        name: '设置',
        component: ()=> import('@/components/Home.vue'),
        children:[{
            path: '/setting',
            icon: 'fa fa-users',
            component: ()=> import('@/components/Setting.vue')
        }]
    },{
        path: '/photo',
        icon: 'el-icon-camera',
        name: '照片墙',
        component: ()=> import('@/components/Home.vue'),
        children:[{
            path: '/photo',
            component: ()=> import('@/components/Photo.vue')
        }]
    },{
        path: '/shop',
        icon: 'el-icon-goods',
        name: '商品',
        component: ()=> import('@/components/Home.vue'),
        children:[{
            path: '/shop',
            component: ()=> import('@/components/Shop.vue')
        }]
    },{
        path: '/users',
        name: '用户中心',
        icon: 'fa fa-address-book-o',
        component: ()=> import('@/components/Home.vue'),
        children:[{
            path: '/users/userList',
            name: '用户管理',
            icon: 'fa fa-users',
            component: ()=> import('@/components/users/UserList.vue')
        },{
            path: '/users/user',
            name: '权限管理',
            icon: 'el-icon-s-custom',
            component: ()=> import('@/components/users/User.vue')
        }]
    }],
    mode: 'hash'
})