<template>
    <tableData :rule="rule" :find="find" :getDatas="getData" :delData="delData" :name="'问题'" :props="[
      {prop: 'id',label: 'ID',fixed: 'left'},
      {prop: 'act',label: '状态',type: 'status',status: [{code: 0,output: '未作答',bgcolor: '#f56c6c'},{code: 1,output: '已作答',bgcolor: '#4acd46'}]},
      {prop: 'content',label: '问题'},
      {prop: 'answer',label: '回答内容'},
      {prop: 'time',label: '出题时间'},
      {prop: 'author',label: '回答用户'},
      {prop: 'atime',label: '答题时间'}
    ]" :AddAndEditForm="AddAndEditForm" :editData="editData" :addData="addData" :backPaging="true"/>
</template>
<script>
  import {get,add,del,edit} from '@/api/api';
  import tableData from "@/components/common/TableData.vue";
  export default {
    name: 'QuestionPage',
    components: {tableData},
    data(){
      return {
        rule: {
          content: [
            {required: true,message: '请输入问题',trigger: 'blur'},
            {min: 2,message: '最少2个字符',trigger: 'blue'}
          ]
        },
        find: {
          id: {strict: 'middle'},
          content: {strict: false,label: '搜索',placeholder: '搜索问题或ID'},
          time: {label: '出题时间',type: 'daterange'},
          act: {label: '状态',type: 'select',selects: [{label: '已作答',value: 1},{label: '未作答',value: 0}],width: '100px',placeholder: '状态',value: 'all'},
          or: [['id','content']]
        },
        AddAndEditForm: {
          id: {act: 'all'},
          content: {label: '问题'},
          act: {label: '状态',type: 'switch',value: 0,activeText: '未作答',inactiveText: '已作答'},
          answer: {label: '回答内容',type: 'textarea',hide: 'add'}
        }
      }
    },
    methods: {
      getData(p,n){
        return get('question',p,n);
      },
      delData(id){
        return del('question',id);
      },
      editData(id,data){
        return edit('question',id,data);
      },
      addData(data){
        return add('question',data);
      }
    }
  }
</script>
<style>
</style>