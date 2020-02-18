<template>
  <div class="near-box">
    <div class="header">
      <router-link to="/address/list" class="left"></router-link>
      收货地址
    </div>
    <div class="bigbox">
        <form @submit.prevent="addressadd">
          <div class="receiv-text1">地址信息</div>
          <div class="receiv-box1">
            <input type="text" v-model="address.consignee" class="receiv-input1" placeholder="收货人姓名（请使用真实姓名）" required>
          </div>
          <div class="receiv-box1">
            <input type="number" v-model="address.mobile" class="receiv-input1" placeholder="手机号码" required>
          </div>

          <div class="delivery-layer-box">
            <div class="cell-item">
              <div class="cell-right cell-arrow">
                  <van-field
                    readonly
                    clickable
                    label="城市"
                    :value="value"
                    placeholder="选择城市"
                    @click="showPicker = true"
                  />
                  <van-popup v-model="showPicker" position="bottom">
                    <van-picker
                      show-toolbar
                      :columns="columns"
                      @cancel="showPicker = false"
                      @confirm="onConfirm"
                      @change="region"
                      ref="region"
                    />
                  </van-popup>
              </div>
            </div>
          </div>

          <div class="receiv-box2">
            <textarea v-model="address.info" class="receiv-input2" placeholder="详细地址" required></textarea>
          </div>
          <button class="set-text1">保存</button>
        </form>
    </div>
  </div>
</template>

<script>
  //省
  var province = []
  var city = []
  var district = []
  export default {
    name:"addressedit",
    created()
    {
      this.user = this.$cookies.get('user')

      //获取传递参数
      this.addrid = this.$route.params.addrid

      this.$store.dispatch('addressinfo',{addrid:this.addrid}).then(success => {
        this.address = success.data.address

        this.value = `${this.address.provinceName}-${this.address.cityName}-${this.address.districtName}`

        //省
        province = success.data.province
        this.columns[0].values = this.columns[0].values.concat(province.map(item => {
          return item.region_name
        }))

        province.forEach((item,index)=>{
          if(item.region_id == this.address.province)
          {
            this.columns[0].defaultIndex = index+1
          }
        })

        //市
        city = success.data.city
        this.columns[1].values = this.columns[1].values.concat(city.map(item=>{
          return item.region_name
        }))
          city.forEach((item,index) => {
          if(item.region_id == this.address.city)
          {
            this.columns[1].defaultIndex = index+1
          }
        })

        //地区
        district = success.data.district
        this.columns[2].values = this.columns[2].values.concat(district.map(item => {return item.region_name}))

        district.forEach((item,index) => {
          if(item.region_id == this.address.district)
          {
            this.columns[2].defaultIndex = index+1
          }
        })
      })
    },
    data()
    {
      return {
        addrid:0,
        user:null,
        address:{
          province:0,
          city:0,
          district:0
        },
        value:'',
        showPicker:false,
        columns: [
          {
            values:['请选择'],
            className: 'column1'
          },
          {
            values:['请选择'],
            className: 'column2'
          },
          {
            values:['请选择'],
            className: 'column3'
          }
        ]
      }
    },
    methods:{
      region(picker, value, column)
      {
        var regionid = 0;
        if(column == 0)
        {
          //第一列 切换省 获取市
          var current = value[0]
          for(var item of province)
          {
            if(item.region_name == current)
            {
              regionid = item.region_id
            }
          }

          this.$refs.region.setColumnValues(2,['请选择'])

          this.$store.dispatch('city',{regionid:regionid}).then(success => {
            city = success.data
            var cityPicker = city.map(item => {return item.region_name})
            cityPicker.unshift('请选择')
            this.$refs.region.setColumnValues(1,cityPicker)
          })
        }else if(column == 1)
        {
          //切换市 选择区域
          var current = value[1]
          for(var item of city)
          {
            if(item.region_name == current)
            {
              regionid = item.region_id
            }
          }

          this.$store.dispatch('district',{regionid:regionid}).then(success => {
            district = success.data
            var districtPicker = district.map(item => {return item.region_name})
            districtPicker.unshift('请选择')
            this.$refs.region.setColumnValues(2,districtPicker)
          })

        }

      },
      onConfirm(value) {
        for(var item of province)
        {
          if(item.region_name == value[0])
          {
            this.address.province = item.region_id
          }
        }

        for(var item of city)
        {
          if(item.region_name == value[1])
          {
            this.address.city = item.region_id
          }
        }

        for(var item of district)
        {
          if(item.region_name == value[2])
          {
            this.address.district = item.region_id
          }
        }
        this.value = value.join(',')
        this.showPicker = false
      },
      addressadd()
      {
        if(!this.address.province || !this.address.city || !this.address.district)
        {
          this.$alert('请选择指定区域');
        }else{
          this.address.userid = this.user.id
          this.$store.dispatch('addressadd',this.address).then(success => {
            if(success.result)
            {
              this.$router.push('/address/list')
            }else{
              this.$alert(success.msg)
            }
          })
        }

      }
    }
  }
</script>


<style scoped>
  @import url('../../static/css/receiving-adress.css');
</style>