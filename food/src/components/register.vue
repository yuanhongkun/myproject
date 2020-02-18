<template>
  <div class="limiter">
      <div class="container-login100" style="background-image: url('/static/images/img-01.jpg');">
          <div class="wrap-login100 p-t-190 p-b-30">
              <form @submit.prevent="register()" class="login100-form validate-form">
                  <div class="login100-form-avatar">
                      <img src="/static/images/avatar-01.jpg" alt="AVATAR">
                  </div>

                  <span class="login100-form-title p-t-20 p-b-45">注册</span>

                  <div class="wrap-input100 validate-input m-b-10" data-validate="请输入用户名">
                      <input class="input100" type="text" v-model="user.username" name="username" placeholder="用户名" required autocomplete="off">
                      <span class="focus-input100"></span>
                      <span class="symbol-input100">
                          <i class="fa fa-user"></i>
                      </span>
                  </div>

                  <div class="wrap-input100 validate-input m-b-10" data-validate="请输入密码">
                      <input class="input100" type="password" name="pass" placeholder="密码" required v-model="user.password">
                      <span class="focus-input100"></span>
                      <span class="symbol-input100">
                          <i class="fa fa-lock"></i>
                      </span>
                  </div>

                  <div class="container-login100-form-btn p-t-10">
                      <button type="submit" class="login100-form-btn">注 册</button>
                  </div>

                  <div class="text-center w-full p-t-25 p-b-230">
                      <router-link to="/login" class="txt1">登录</router-link>
                  </div>
              </form>
          </div>
      </div>
  </div>
</template>


<script>
  export default {
    name:"register",
    created()
    {
      var user = this.$cookies.get('user')

      if(user)
      {
        this.$router.push('/my')
      }
    },
    data()
    {
      return {
        user:{}
      }
    },
    methods:{
      register()
      {
        this.$store.dispatch('register',this.user).then(register => {
          if(register.result)
          {
            //跳转到登录界面
            this.$router.push('/login')
          }else{
            this.$alert(register.msg)
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