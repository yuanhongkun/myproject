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
                        <h3 class="text-themecolor">编辑管理员</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form role="form" @submit.prevent="editadmin(admin.id)">
                                    <div class="form-group">
                                        <label for="name">管理员账号</label>
                                        <input type="text" class="form-control" id="name" v-model="admin.name" name="name" required placeholder="请输入管理员账号">
                                        <label for="password">密码</label>
                                        <input type="password" class="form-control" id="password" v-model="admin.password" name="password" required placeholder="请输入密码">
                                        
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
    name:"adminadd",
    components:{
        commonHeader,
        asideList
    },
    created()
    {

        this.adminid=this.$route.query.adminid
        this.$store.dispatch("admininfo",{adminid:this.adminid}).then(success=>{
            if(success.result)
            {
                this.admin = success.data
            }else{
                this.$alert(success.msg)
            }
        })
        
    },
    data()
    {
        return{
            admin:{},
            adminid:0,
        }
    },
    methods:{
        editadmin(adminid)
        {
            
            this.$store.dispatch("editadmin",{adminid:adminid,name:this.admin.name,password:this.admin.password}).then(success=>{
                if(success.result)
                {
                    
                    this.$router.push('/admin')
                }else{
                    this.$alert(success.msg)
                }
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