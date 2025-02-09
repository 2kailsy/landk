export function setToken(key,token){
    return localStorage.setItem(key,token);
}
export function getToken(key){
    let v=localStorage.getItem(key);
    if(!v){v='null';}
    return v;
}
export function removeToken(key){
    return localStorage.removeItem(key);
}