import axios from 'axios'
import QS from 'qs'

//设置请求的超时时间
axios.defaults.timeout = 10000;

// post请求头
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';

export function request({method, url, params}){
    if(method == 'get'){
        return get(url, params);
    }else if(method == 'post'){
        return post(url, params);
    }else if(method == 'file'){
        return file(url,params);
    }
}

function get(url,params)
{
  return new Promise((resolve,reject) => {
    axios.get(url,params).then(res => {
      resolve(res.data) //返回数据
    }).catch(err => {
      reject(false) //错误
    })
  })
}

function post(url,params)
{
  return new Promise((resolve,reject) => {
    axios.post(url, QS.stringify(params)).then(res => {
      resolve(res.data) //返回数据
    }).catch(err => {
      reject(false)  //返回错误
    })
  })
}

function file(url,params)
{
  return new Promise((resolve, reject) => {
    axios.post(url, params).then(res => {
      resolve(res.data) //返回数据
    }).catch(err => {
      reject(false)  //返回错误
    })
  })
}