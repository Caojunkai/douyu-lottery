<template>
    <el-menu theme="light" :default-active="activeIndex" mode="horizontal" @select="handleSelect">
        <el-menu-item index="1"><a v-bind:href="appLink">{{ appName }}</a></el-menu-item>
        <el-menu-item index="2"><a :href="lotteryLink">{{ lotteryName }}</a></el-menu-item>
        <el-submenu index="3" class="el-menu-item-auth" v-if="isLogin">
            <template slot="title">{{ userName }}</template>
            <el-menu-item index="logout">退出</el-menu-item>
        </el-submenu>
        <div class="el-menu-item-auth" v-else>
                <el-menu-item index="3-1" ><a :href="loginLink">登录</a></el-menu-item>
                <el-menu-item index="3-2" ><a :href="registerLink">注册</a></el-menu-item>
        </div>
    </el-menu>
</template>

<style scoped>
    .el-menu-item-auth{
        margin-right: 2rem;
        float: right;
    }
    .el-menu-item a{
        display: block;
        text-decoration: none;
    }
    .el-menu-item-auth .el-menu-item:hover{
        border-bottom: solid rgb(32, 160, 255) 5px;
    }

</style>

<script>
    export default{
      name:'DouyuNavbar',
      data() {
        return {
          activeIndex: '1',
        };
      },
      methods: {
        handleSelect(key, keyPath) {
          if (key == 'logout') {
                this.axios.post(this.logoutLink).then(function (response) {
                   window.location.reload();
                });
          }
        }
      },
      props:[
        'appName',
        'appLink',
        'lotteryName',
        'lotteryLink',
        'isLogin',
        'userName',
        'logoutLink',
        'loginLink',
        'registerLink'
      ]
    }
</script>
