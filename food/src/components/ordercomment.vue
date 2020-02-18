<template>
  <div class="near-box">
      <div class="header">
        <router-link to="/order/list" class="left"></router-link>
        发表评价
      </div>
      <form @submit.prevent="commentAdd()">
        <div class="jd-qrdd-bigbox">
          <div class="tb-pj-a1" v-if="orderinfo.orderpro">
              <span class="tbpj-a1-i1">
                <img v-if="orderinfo.orderpro[0].cover" :src="CDN + orderinfo.orderpro[0].cover">
                <img v-else src="/static/del/fruits-img7.png">
              </span>
              <span class="tbpj-a1-t1">{{orderinfo.orderpro[0].name}}</span>
          </div>
          <div class="tb-pj-a2">
              <textarea class="tbpj-a2-input" placeholder="请输入评价内容" required v-model="comment.content"></textarea>
          </div>
          <div class="tb-pj-a1">
              <van-checkbox class="isshow" v-model="isshow" checked-color="#E71431"></van-checkbox>
              <span class="tbpj-a1-t2">匿名评价</span>
              <span class="tbpj-a1-t3">你写的评价会以匿名形式展现</span>
          </div>
          <div class="tb-pj-a1">
              <span class="tbpj-a1-t4">描述相符</span>
              <div class="tbpj-a1-b1">
                <van-rate v-model="comment.rate" />
              </div>
          </div>
            <div class="serve-type-box1">
            <span class="serve-type-text2">上传评价(至少两张)：</span>
            <div class="thumbBox">
              <van-uploader class="thumbList" v-model="fileList" multiple :max-count="9" :after-read="upload" />
            </div>
            </div>
          <button type="submit" class="tb-pj-c1">发表评价</button>
        </div>
      </form>
  </div>
</template>

<script>
  export default {
    name:"ordercomment",
    created()
    {
      this.user = this.$cookies.get('user')
      this.orderid = this.$route.query.orderid

      this.$store.dispatch("orderinfo",{orderid:this.orderid}).then(success => {
        if(success.result)
        {
          
          this.orderinfo = success.data
        }else{
          this.$alert(success.msg).then(res => {
            this.$router.push('/order/list')
          }).catch(err => {})
        }
      })
    },
    data()
    {
      return {
        user:null,
        orderid:0,
        orderinfo:{},
        CDN:this.CDN,
        comment:{
          rate:0,
        },
        isshow:true,
        formData:new FormData(),
        fileList:[]
      }
    },
    methods:{
      commentAdd()
      {
        this.formData.append("orderid",this.orderid)
        
        this.formData.append("rate",this.comment.rate)
        this.formData.append("content",this.comment.content)
        this.formData.append("isshow",this.isshow ? 0 : 1)

        //提交actions
        this.$store.dispatch("commentAdd",this.formData).then(success => {
          if(success.result)
          {
            this.$alert(success.msg).then(res => {
              this.$router.go(-1)
            }).catch(err => {})
          }else{
            this.$alert(success.msg)
          }
        })
      },
      upload(file)
      {
        console.log(file)
        //if(file)
        for(var item of file)
        {
          this.formData.append('thumb',item.file)
        }
      }
    }
  }
</script>

<style>
  @import url('../../static/css/pj.css');

  .isshow{
    display: inline-block;
    float:left;
  }
  .thumbList{
    display:flex;
    width:375px;
  }
</style>