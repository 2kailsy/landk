<template>
    <tableData :rule="rule" :find="find" :getDatas="getData" :delData="delData" :name="'设置'" :props="[
        {prop:'k',label:'设置名称',order:0,fixed: 'left'},
        {prop:'v',label:'值',order:1}
    ]" :AddAndEditForm="AddAndEditForm" :editData="editData" :addData="addData" :backPaging="true"/>
</template>
<script>
import tableData from "./common/TableData.vue";
import {get,add,del,edit} from "@/api/api.js";
export default {
    name: 'SettingPage',
    components: {
        tableData,
    },
    data() {
        return {
            rule: {
                k: [
                    { required: true, message: "请输入设置名称", trigger: "blur" },
                    {
                        min: 2,
                        max: 80,
                        message: "设置名称应在2-80个字符之间",
                        trigger: "blur",
                    },
                ]
            },
            find:{
                k:{
                    strict: false,
                    label: "搜索设置",
                    placeholder: "设置名称/值",
                },
                v:{strict:false},
                or: ["k","v"]
            },
            AddAndEditForm: {
                id:{hide:"all"},
                k:{label:"设置名称",prop:"k",value:""},
                v:{label:"设置值",type:"textarea",value:""},
                hide:{
                    label: "前端显示",
                    type: "switch",
                    inactiveText: "不显示",
                    activeText: "显示",
                    value: 0
                },
                template:{
                    label: "模板",
                    type: "template",
                    value: [],
                    model: "v",
                    valueFormats: "json",
                }
            },
        };
    },
    methods: {
        async getData(p,n){return get('settings',p,n);},
        delData(id){return del('settings',id);},
        editData(id,data){return edit('settings',id,data);},
        addData(data){return add('settings',data);}
    },
}
</script>