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
                        <h3 class="text-themecolor">管理员</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">管理员列表</h4>
                                <router-link to="/admin/add" class="card-subtitle">添加 <code>+</code></router-link>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>昵称</th>
                                                <th>创建时间</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in admin">
                                                <td>{{item.id}}</td>
                                                <td>{{item.name}}</td>
                                                <td>{{item.createdtime | dateformat}}</td>
                                                <td>
                                                    <button class="btn btn-primary" @click="edit(item.id)">编辑</button>
                                                    <button class="btn btn-danger" @click="del(item.id)">删除</button>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
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
    name: 'admin',
    components:{
        commonHeader,
        asideList
    },
    created()
    {
        this.admin = this.$cookies.get("admin")
        this.$store.dispatch("adminlist").then(success=>{
            if(success.result)
            {
                this.admin=success.data
            }else{
                this.$alert(success.msg)
            }
        })
    },
    data()
    {
        return {
            admin:null,
        }
    },
    methods:{
        edit(adminid)
        {
            this.$router.push({name:"editadmin",query:{adminid:adminid}})
        },
        del(adminid)
        {
            this.$store.dispatch("deleteadmin",{adminid:adminid}).then(success=>{
                this.$alert(success.msg)
                
                this.$router.go(0)
                     
            })
        }
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