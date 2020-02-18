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
                        <h3 class="text-themecolor">添加商品分类</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form role="form" @submit.prevent="addgoodscate(goodscate.id)">
                                    <div class="form-group">
                                        <label for="name">商品名称</label>
                                        <input type="text" class="form-control" id="name" v-model="goodscate.name" name="name" required placeholder="请输入商店名称">
                                        <label for="password">商品类型</label>
                                        <select name="" id="" v-model="goodscate.typeid">
                                            <template >
                                                <option v-for="item in foodtype" :value="item.id">{{item.name}}</option>
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
        name: 'addgoodscate',
        components:{
            commonHeader,
            asideList
        },
        data()
        {
            return {
                foodtype:[],
                goodscate:{},
                goodscateid:0,
                
            }
        },
        created()
        {
            this.goodscateid = this.$route.query.goodscateid
            //console.log(this.goodscateid)
            this.$store.dispatch("goodscateinfo",{goodscateid:this.goodscateid}).then(success=>{
                if(success.result)
                {
                    //this.goodscate = success.data.goodscate
                    this.foodtype = success.data.foodtype
                }else{
                    this.$alert(success.msg)
                }
            })
            

        },
        methods:{
            addgoodscate(addgoodscateid)
            {
                this.$store.dispatch("addgoodscate",this.goodscate).then(success=>{
                    if(success.result)
                    {
                        this.$router.push('/goodscate')
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