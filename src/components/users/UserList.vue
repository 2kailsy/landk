<template>
    <tableData :rule="rule" :find="find" :getDatas="getData" :delData="delData" :name="'用户'" :props="[
        {prop: 'id',label: 'ID',order: 0},
        {prop: 'usr',label: '用户名',order: 1},
        {prop: 'sort',label: '用户类型',order: 2},
        {prop: 'time',label: '注册时间',order: 3}
    ]" :AddAndEditForm="AddAndEditForm" :editData="editData" :addData="addData" :backPaging="true" :getInfo="getUserInfo" :status.sync="status" @update:editOrAdd="status=$event"/>
</template>
<script>
  import {get,add,del,edit,getUserInfo} from '@/api/api';
  import tableData from "@/components/common/TableData.vue";
  export default {
    name: 'UserList',
    components: {tableData},
    data(){
      return {
        data: [],
        status: 'add',
        rule: {
            usr: [
                {required: true,message: '请输入',trigger: 'blur'},
                {min: 2,message: '最少2个字符',trigger: 'blue'}
            ],
            pwd: [{required: true,
                validator:(rule,value,callback)=>{
                    if(rule.hidden==this.status){callback();return;}
                    if(!value){callback(new Error('请输入'));}else{callback();return;}
                    if(((value||'').trim().length)<6){callback(new Error('至少6位'));}else{callback();return;}
                },
                trigger: 'blur',
                hidden: 'edit'
            }],
            nickname: [
                {required: true,message: '请输入',trigger: 'blur'},
                {min: 2,message: '最少2位',trigger: 'blue'}
            ],
            birth: [{required: true,message: '请输入',trigger: 'blur'}],
            birthday: [{required: true,message: '请输入',trigger: 'blur'}],
        },
        find: {
            id: {strict: false,},
            usr: {strict: false,label: '搜索',placeholder: '搜索用户名或ID'},
            sort: {strict: true,value: 'all',type: 'select',label: '类型',placeholder: '',width: '80px',selects: [{value: '管理',label: '管理'},{value: '用户',label: '用户'},{value: '游客',label: '游客'}]},
            time: {label: '时间',type: 'daterange'},
            or: [['id','usr']]
        },
        AddAndEditForm: {
            id: {hide: 'all'},
            usr: {label: '用户名'},
            pwd: {label: '密码',type: 'password'},
            sort: {label: '类型',placeholder: '请选择账户类型',type: 'select',width: '50%',selects: [{value: '管理',label: '管理'},{value: '用户',label: '用户'},{value: '游客',label: '游客'}],value: '用户'},
            nickname: {label: '昵称'},
            sex: {label: '性别',type: 'radio',border: true,radios: [{value: '男',label: '男'},{value: '女',label: '女'},{value: '无',label: '未知'}],value: '无'},
            point: {label: '积分',step: 1,stepStrictly: true,type: 'numberInput',hide: 'add'},
            see: {label: '访问次数',step: 1,stepStrictly: true,type: 'numberInput',hide: 'add'},
            birth: {label: '阳历生日',placeholder: '选择阳历生日',valueFormat: 'yyyy-MM-dd',format: 'yyyy年MM月dd日',type: 'date',value: ''},
            birthday: {label: '阴历生日',placeholder: '选择阴历生日',valueFormat: 'MM-dd',format: 'MM月dd日',popperClass: 'picker-date',type: 'date',value: ''},
            description: {label: '个人简介',type: 'textarea_max',placeholder: '请输入个人简介',max: 50,value: ''},
            headsolt: {label: '头像',type: 'upload',uploadUrl: '/api/upload/user',value: ''},
        }
      }
    },
    methods: {
        getData(p,n){return get('personal',p,n);},
        delData(id){return del('personal',id);},
        editData(id,data){return edit('personal',id,data);},
        addData(data){return add('personal',data);},
        getUserInfo(id){return getUserInfo(id).then((res)=>{return res.data||{};});},
    }
  }
  </script>
  <style>
</style>