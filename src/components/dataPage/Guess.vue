<template>
    <table-data :rule="rule" :find="find" :getDatas="getData" :delData="delData" :name="'猜猜'" :props="[
      {prop: 'id',label: 'ID',fixed: 'left'},
      {prop: 'content',label: '内容'},
      {prop: 'ranswer',label: '正确答案',color: '#4acd46'},
      {prop: 'answers',label: '回答',type: 'split',str: '||'},
      {prop: 'answert',label: '回答时间',type: 'split',str: '||'},
      {prop: 'shows',label: '状态',type: 'status',status: [{code: 0,output: '显示',bgcolor: '#f56c6c'},{code: 1,output: '隐藏',bgcolor: '#4acd46'}]},
      {prop: 'time',label: '时间'}
    ]" :AddAndEditForm="AddAndEditForm" :editData="editData" :addData="addData" :backPaging="true"/>
</template>
<script>
import {get,add,del,edit} from '@/api/api';
import TableData from "@/components/common/TableData.vue";
export default {
  name: 'GuessPage',
  components: {TableData},
  data(){
    return {
      rule: {
        content: [
          {required: true,message: '请输入',trigger: 'blur'},
          {min: 2,message: '最少2个字符',trigger: 'blue'}
        ],
        ranswer: [
          {required: true,message: '请输入',trigger: 'blur'},
          {min: 2,message: '最少2个字符',trigger: 'blue'}
        ]
      },
      find: {
        content: {strict: false,label: '搜索',placeholder: '搜索内容或回答'},
        answers: {strict: false},
        time: {label: '时间',type: 'daterange'},
        or: [['content','answers']]
      },
      AddAndEditForm: {
        id: {act: 'all'},
        content: {label: '猜猜'},
        ranswer: {label: '正确答案'},
        shows: {label: '状态',type: 'switch',value: 0,activeText: '显示',inactiveText: '隐藏'}
      }
    }
  },
  methods: {
    getData(p,n){
      return get('guess',p,n);
    },
    delData(id){
      return del('guess',id);
    },
    editData(id,data){
      return edit('guess',id,data);
    },
    addData(data){
      return add('guess',data);
    }
  }
}
</script>
<style>
</style>