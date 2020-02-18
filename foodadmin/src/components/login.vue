<template>
  <div class="limiter">
      <div class="container-login100" style="background-image: url('/static/assets/images/img-01.jpg');">
          <div class="wrap-login100 p-t-190 p-b-30">
              <form @submit.prevent="login()" class="login100-form validate-form">
                  <div class="login100-form-avatar">
                      <img src="/static/assets/images/avatar-01.jpg" alt="AVATAR">
                  </div>

                  <span class="login100-form-title p-t-20 p-b-45">登录</span>

                  <div class="wrap-input100 validate-input m-b-10" data-validate="请输入用户名">
                      <input class="input100" type="text" v-model="admin.name" name="name" placeholder="用户名" required autocomplete="off">
                      <span class="focus-input100"></span>
                      <span class="symbol-input100">
                          <i class="fa fa-user"></i>
                      </span>
                  </div>

                  <div class="wrap-input100 validate-input m-b-10" data-validate="请输入密码">
                      <input class="input100" type="password" name="pass" placeholder="密码" required v-model="admin.password">
                      <span class="focus-input100"></span>
                      <span class="symbol-input100">
                          <i class="fa fa-lock"></i>
                      </span>
                  </div>

                  <div class="container-login100-form-btn p-t-10">
                      <button type="submit" class="login100-form-btn">登 录</button>
                  </div>

                  
              </form>
          </div>
      </div>
  </div>
</template>


<script>
  
  export default {
    
    name:"login",
    
    created()
    {
      var admin = this.$cookies.get('admin')

      if(admin)
      {
        this.$router.push('/admin')
      }
    },
    data()
    {
      return {
        admin:{}
      }
    },
    methods:{
      login()
      {
        this.$store.dispatch("login",this.admin).then(login => {
          
          if(login.result)
          {
            this.$cookies.set('admin',login.data)
            
            this.$router.push('/admin')
          }else{
            this.$alert(login.msg)
          }
        })
      }
    }
  }
</script>


<style scoped>
  @import url('../../static/fonts/font-awesome-4.7.0/css/font-awesome.min.css');
  @import url('../../static/css/util.css');
  @import url('../../static/css/main.css');
</style>