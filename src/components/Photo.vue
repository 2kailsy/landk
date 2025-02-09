<template>
    <tableData
        :rule="photoRule"
        :find="find"
        :getDatas="getPhotos"
        :delData="delPhoto"
        :name="'照片'"
        :AddAndEditForm="AddAndEditForm"
        :editData="editPhoto"
        :addData="addPhoto"
        :backPaging="true"
        :props="[
            {prop: 'id',label: 'ID',order: 0,fixed: 'left'},
            {prop: 'imageUrl',label: '图片',type: 'img',mask_prop: 'time',order: 1},
            {prop: 'title',label: '标题',order: 2},
            {prop: 'content',label: '内容',order: 3},
            {prop: 'time',label: '时间',order: 4},
        ]">
    </tableData>
</template>
<script>
    import tableData from './common/TableData.vue';
    import {get,add,del,edit} from '@/api/api.js';
    export default {
        name: 'PhotoPage',
        components:{tableData},
        data(){
            return{
                photoRule: {
                    title: [
                        {required: true,message: '请输入图片标题',trigger: 'blur'},
                        {min: 2,max: 64,message: '标题要在2-64个字符之间喔',trigger: 'blur'}  
                    ],
                    imageUrl: [{required: true,message: '选张图片叭',trigger: 'blur'}],
                    time: [{required: true,message: '记得填日期呀',trigger: 'blur'}],
                    content: [{required: true,message: '写一句话来描述这张图片叭',trigger: 'blur'}]
                },
                find: {
                    title: {value: '',strict: false,label: '搜索图片',placeholder: '标题/内容'},
                    content: {value: '',strict: false},
                    date: {value: [],type: 'daterange',label: '时间'},
                    or: [['title','content']]
                },
                AddAndEditForm: {
                    id: {label: 'ID',prop: 'id',value: '',hide: 'all'},
                    title: {label: '标题',prop: 'title',type: 'input',value: ''},
                    imageUrl: {label: '图片',prop: 'imageUrl',type: 'upload',uploadUrl: '/api/upload/picture',value: ''},
                    show: {label: '照片显示',prop: 'hide',type: 'switch',value: 0},
                    time: {label: '照片日期',prop: 'time',type: 'datetime',value: ''},
                    content: {label: '内容(简介)',prop: 'content',type: 'textarea',value: ''},
                    date: {label: '时间',prop: 'date',value: '',hide: 'all'}
                }
            }
        },
        methods: {
            getPhotos(p,n){return get('picture',p,n);},
            delPhoto(id){return del('picture',id);},
            editPhoto(id,data){return edit('picture',id,data);},
            addPhoto(data){return add('picture',data);}
        }
    }
</script>