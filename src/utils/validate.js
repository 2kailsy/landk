export function usernameRule(rule,value,callback){
    let reg=/(^[a-zA-Z0-9]{2,18}$)/;
    if(value===''){callback(new Error('请输入用户名'))}else
    if(!reg.test(value)){callback(new Error('用户名必须是2-18位字符'))}else{callback();}
}
export function passwordRule(rule,value,callback){
    // let reg=/^\S*(?=\S{6,32})(?=\S*\d)(?=\S*[A-Z])(?=\S*[a-z])(?=\S*[!@#$%^&*?"'./])\S*$/;
    let reg=/(^[a-zA-Z0-9]{2,18}$)/;
    if(value===''){callback(new Error('请输入密码'))}else
    if(!reg.test(value)){callback(new Error('密码必须是6-32位且包含大小写字母和数字及特殊符号'))}else{callback();}
}