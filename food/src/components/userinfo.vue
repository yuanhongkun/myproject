<template>
  <div class="near-box">
    <div class="header">
      <router-link to="/my" class="left"></router-link>
      个人信息
    </div>
    <div class="bigbox">
      <form @submit.prevent="userinfo()">
        <div class="receiv-text1">
          <div class="avatar" v-if="user.avatar">
            <img :src="CDN + user.avatar" onclick="avatar.click()" />
          </div>
          <div class="avatar" v-else onclick="avatar.click()">
            <img src="/static/del/timg1.jpg" >
          </div>
          <input type="file" @change="upload($event)" id="avatar" style="display:none">
        </div>
        <div class="receiv-box1">
          <input type="text" v-model="user.username" class="receiv-input1" placeholder="请输入用户名" required>
        </div>
        <div class="receiv-box1">
          <input type="password" v-model="user.password" class="receiv-input1" placeholder="密码为空不修改">
        </div>
        <button type="submit" class="set-text1">保存</button>
      </form>
    </div>

  </div>
</template>

<script>
  export default {
    name:"userinfo",
    created()
    {
      this.user = this.$cookies.get('user')
    },
    data()
    {
      return {
        user:null,
        CDN:this.CDN
      }
    },
    methods:{
      upload(event)
      {
        //获取到选取的第一张图片
        var avatar = event.target.files[0]
        //创建一个表单数据对象
        var data = new FormData()
        data.append("avatar",avatar)
        data.append("userid",this.user.id)

        //直接传递给actions
        this.$store.dispatch('avatar',data).then(success => {
          if(success.result)
          {
            this.$cookies.set('user',success.data)
            this.user = success.data
          }else{
            this.$alert(success.msg)
            return false
          }
        })
      },
      userinfo()
      {
       this.$store.dispatch('userinfo',this.user).then(success => {
         if(success.result)
         {
           this.$cookies.set('user',success.data)
           this.$router.push('/my')
         }else{
           this.$alert(success.msg)
         }
       })
      }
    }
  }
</script>

<style scoped>
  @import url('../../static/css/receiving-adress.css');

  .avatar{
    width:100px;
    height:100px;
    border-radius: 100%;
    overflow: hidden;
    margin:10px auto;
  }

  .avatar img{
    width:100%;
    height:100%;
  }
</style>