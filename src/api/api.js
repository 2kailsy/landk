import service from '../service';
//登录接口
export function login(data){
    return service({
        url: '/login',
        method: 'post',
        data: data
    }).then((rs)=>{return rs.data;});
}
export function check(){
    return service({
        url: '/check',
        method: 'get'
    }).then((rs)=>{return rs.data;});
}
// 用户接口
export function delUser(id){
    return service({
        url: `/admin/deleteUser?id=${id}`,
        method: 'get'
    }).then((rs)=>{return rs.data;});
}
export function getUserInfo(id){
    return service({
        url: `/admin/personal`,
        method: 'post',
        data: {
            type: 'getPerson',
            uid: id
        }
    }).then((rs)=>{return rs.data;});
}
export function editUser(id,data){
    return service({
        url: `/admin/personal`,
        method: 'post',
        data: {types: 'edit',...data,uid: id}
    });
}
export function addUser(data){
    return service({
        url: `/register`,
        method: 'post',
        data: data
    });
}
// 系统信息
export function getSystemInfo(){
    return service({
        url: `/admin/system`,
        method: 'post',
        data: {type: 'get'}
    }).then((rs)=>{
        try{
            rs.data=rs.data.data;
            return {
                system: [
                    {value: rs.data['title'],label: '网站名称'},
                    {value: rs.data['version'],label: '系统版本'},
                    {value: rs.data['name'],label: '系统'},
                    {value: rs.data['php'],label: 'PHP版本'},
                    {value: rs.data['mysql'],label: 'MySQL版本'},
                    {value: (rs.headers['server']).split(' ')[0],label: '运行环境'},
                    {value: rs.data['upload_max_size'],label: '上传限制'}
                ],
                article_total: rs.data['article_total'],
                images_total: rs.data['images_total'],
                sayme_total: rs.data['sayme_total'],
                run_time: rs.data['run_time'],
            }
        }catch(error){}
    });
}
// 问题接口
export function get(url,p=5,n=1){
    return service({
        url: `/admin/${url}`,
        method: 'post',
        data: {type: 'get',p: p,n: n}
    }).then((rs)=>{return rs.data;});
}
export function add(url,data){
    return service({
        url: `/admin/${url}`,
        method: 'post',
        data: {type: 'add',...data}
    }).then((rs)=>{return rs.data;});
}
export function del(url,id){
    return service({
        url: `/admin/${url}`,
        method: 'post',
        data: {type: 'del',id: id}
    }).then((rs)=>{return rs.data;});
}
export function edit(url,id,data){
    return service({
        url: `/admin/${url}`,
        method: 'post',
        data: {type: 'edit',id: id,...data}
    }).then((rs)=>{return rs.data;});
}
//签到接口
export function getSign(year,month){
    return service({
        url: `/admin/sign`,
        method: 'post',
        data: {type: 'get',year,month}
    }).then((rs)=>{return rs.data;});
}