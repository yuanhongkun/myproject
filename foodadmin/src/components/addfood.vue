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
                        <h3 class="text-themecolor">添加食品</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form role="form" @submit.prevent="addfood(food.id)">
                                    <div class="form-group">
                                        <label for="name">食品名称</label>
                                        <input type="text" class="form-control" id="name" v-model="food.name" name="name" required placeholder="请输入食品名称">
                                        
                                        <label for="price">食品价格</label>
                                        <input type="number" class="form-control" id="price" v-model="food.price" name="price" required placeholder="请输入食品价格">
                                        <label for="description">食品描述</label>
                                        <input type="text" class="form-control" id="description" v-model="food.description" name="description" required placeholder="请输入食品描述">
                                        <label for="thumb">食品图集</label>
                                        <input type="text" class="form-control" id="thumb" v-model="food.thumb" name="thumb" required placeholder="请输入食品图集地址">
                                        <label for="stock">食品库存数</label>
                                        <input type="number" class="form-control" id="stock" v-model="food.stock" name="stock" required placeholder="请输入食品库存数">
                                        <label for="">食品分类</label>
                                        <select name="" id="" v-model="food.cateid">
                                            <template >
                                                <option v-for="item in foodcate" :value="item.id">{{item.name}}</option>
                                            </template>
                                        </select>
                                    
                                        
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
        name: 'addfood',
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
                    //this.food = success.data.food
                    this.foodcate = success.data.foodcate
                }else{
                    this.$alert(success.msg)
                }
            })
            

        },
        methods:{
            addfood(addfoodid)
            {
                this.$store.dispatch("addfood",this.food).then(success=>{
                    if(success.result)
                    {
                        this.$router.push('/goodslist')
                    }else{
                        this.$alert(success.msg)
                    }
                })
            },
            
        }
    }
</script>
<style scoped>
    @import url("../../static/assets/plugins/chartist-js/dist/chartist.min.css");
    @import url("../../static/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css");
    @import url("../../static/assets/plugins/c3-master/c3.min.css");
    @import url("../../static/html/css/pages/dashboard.css");
    @import url("../../static/html/css/colors/default-dark.css");
</style>