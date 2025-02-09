<template>
  <tableData :rule="rule" :find="find" :getDatas="getData" :delData="delData" :name="'小纸条'" :props="[
    {prop: 'pwd',label: '密钥',fixed: 'left'},
    {prop: 'content',label: '内容'},
    {prop: 'look',label: '查看时间',type: 'split',str: '||'},
    {prop: 'date',label: '时间'}
  ]" :AddAndEditForm="AddAndEditForm" :editData="editData" :addData="addData" :backPaging="true"/>
</template>
<script>
import {get,add,del,edit} from '@/api/api';
import tableData from "@/components/common/TableData.vue";
export default {
  name: 'PaperPage',
  components: {tableData},
  data(){
    return {
      rule: {
        content: [
          {required: true,message: '请输入',trigger: 'blur'},
          {min: 2,message: '最少2个字符',trigger: 'blue'}
        ],
        pwd:[{required: true,message: '请输入密钥',trigger: 'blur'}]
      },
      find: {
        pwd: {strict: false},
        content: {strict: false,label: '搜索',placeholder: '搜索内容或密钥'},
        time: {label: '时间',type: 'daterange'},
        or: [['content','pwd']]
      },
      AddAndEditForm: {
        id: {act: 'all'},
        pwd: {label: '密钥',type: 'password'},
        content: {label: '小纸条',type: 'textarea'},
      }
    }
  },
  methods: {
    getData(p,n){return get('paper',p,n);},
    delData(id){return del('paper',id);},
    editData(id,data){return edit('paper',id,data);},
    addData(data){return add('paper',data);}
  }
}
</script>
<style>
</style>