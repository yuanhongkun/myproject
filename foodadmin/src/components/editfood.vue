<template>
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <common-header></common-header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside-list></aside-list>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">编辑食品</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form role="form" @submit.prevent="editfood(food.id)">
                                    <div class="form-group">
                                        <label for="name">食品名称</label>
                                        <input type="text" class="form-control" id="name" v-model="food.name" >
                                        
                                        <label for="name">食品价格</label>
                                        <input type="number" class="form-control" id="name" v-model="food.price" >
                                        <label for="name">食品描述</label>
                                        <input type="text" class="form-control" id="name" v-model="food.description" >
                                        <label for="name">食品图集</label>
                                        <input type="text" class="form-control" id="name" v-model="food.thumb">
                                        <label for="name">食品库存数</label>
                                        <input type="number" class="form-control" id="name" v-model="food.stock">
                                        <label for="">食品分类</label>
                                        <select name="" id="" v-model="food.cateid">
                                            <template >
                                                <option v-for="item in foodcate" :value="item.id">{{item.name}}</option>
                                            </template>
                                        </select>
                                        <div class="cover" v-if="food.cover">
                                            <img :src="CDN + food.cover" onclick="cover.click()" />
                                        </div>
                                        <div class="cover" v-else onclick="cover.click()">
                                            <img src="/static/assets/images/fruits-img4.png" >
                                        </div>
                                        <input type="file" @change="upload($event)" id="cover" style="display:none">
                                        
                                        
                                    </div>
                                    
                                    <button type="submit" class="btn btn-default">提交</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
           
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
</template>
<script>
import commonHeader from './commonHeader'
import asideList from './asideList'
    export default {
        name: 'editfood',
        components:{
            commonHeader,
            asideList
        },
        data()
        {
            return {
                foodcate:[],
                food:{},
                foodid:0,
                
            }
        },
        created()
        {
            this.foodid = this.$route.query.foodid
            //console.log(this.foodid)
            this.$store.dispatch("foodinfo",{foodid:this.foodid}).then(success=>{
                if(success.result)
                {
                    this.food = success.data.food
                    this.foodcate = success.data.foodcate
                }else{
                    this.$alert(success.msg)
                }
            })
            

        },
        methods:{
            editfood(editfoodid)
            {
                this.$store.dispatch("editfood",this.food).then(success=>{
                    if(success.result)
                    {
                        this.$alert(success.msg)
                        this.$router.push('/goodslist')
                    }else{
                        this.$alert(success.msg)
                    }
                })
            },
            upload(event)
            {
                //获取到选取的第一张图片
                var cover = event.target.files[0]
                //创建一个表单数据对象
                var data = new FormData()
                data.append("cover",cover)
                data.append("foodid",this.food.id)

                console.log(cover)
                //直接传递给actions
                this.$store.dispatch('foodcover',data).then(success => {
                    if(success.result)
                    {
                        this.food = success.data
                    }else{
                        this.$alert(success.msg)
                        return false
                    }
                })
            },
        }
    }
</script>