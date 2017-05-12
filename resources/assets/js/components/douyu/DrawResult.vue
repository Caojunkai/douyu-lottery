<template>
<el-row class="lottery-content">
    <el-col :span="6" :offset="4" class="lottery-content-left" v-loading="loadingGifts" element-loading-text="拼命加载中">
        <div class="grid-content lottery-content-left-content" id="lottery-content-left-content">
            <div v-for="lotteryUser in lotteryUsers" :key="lotteryUser.cid" class="lottery-content-left-content-item">
                <el-row v-if="lotteryUser.cid == lucknum" style="border:2px dashed red">
                    <el-col :span="2">{{lotteryUser.cid}}</el-col>
                    <el-col :span="4">
                        <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1494331517247&di=da53acca7260e0770a6424779497126b&imgtype=0&src=http%3A%2F%2Fpic2.orsoon.com%2F2016%2F1215%2F20161215100547239.jpg">
                    </el-col>
                    <el-col :span="6">{{ lotteryUser.douyu_name }}</el-col>
                    <el-col :span="12">{{ lotteryUser.vote_time }}</el-col>
                </el-row>
                <el-row v-else>
                    <el-col :span="2">{{lotteryUser.cid}}</el-col>
                    <el-col :span="4">
                        <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1494331517247&di=da53acca7260e0770a6424779497126b&imgtype=0&src=http%3A%2F%2Fpic2.orsoon.com%2F2016%2F1215%2F20161215100547239.jpg">
                    </el-col>
                    <el-col :span="6">{{ lotteryUser.douyu_name }}</el-col>
                    <el-col :span="12">{{ lotteryUser.vote_time }}</el-col>
                </el-row>
            </div>
        </div>
    </el-col>
    <el-col :span="10" class="lottery-content-right">
        <div class="block">
            <div class="lottery-content-result">
                <transition name="bounce">
                    <div class="lottery-content-result-clearup">
                        <h1>抽奖已结束</h1>
                        <h1>中奖序号为：<span style="color: red;">{{lucknum}}</span></h1>
                        <h1>获奖用户为：<span style="color: green">{{luckier.douyu_name}}</span></h1>
                    </div>
                </transition>
            </div>
        </div>
    </el-col>
    <!-- 中奖纪录查询 -->
    <el-col :span="2" class="lottery-content-result-btn">
        <el-button type="success" @click="getLotteryResult" icon="search">中奖纪录</el-button>
    </el-col>
    <!-- dialog -->
    <el-dialog title="中奖纪录" :visible.sync="dialogTableVisible">
        <el-table :data="DrawResultData" style="width: 100%">
            <el-table-column property="douyu_name" label="姓名" width="300"></el-table-column>
            <el-table-column property="created_at" label="日期"></el-table-column>
        </el-table>
        <div class="block">
            <el-pagination @current-change="DrawResultCurrentChange" :current-page.sync="DrawResultCurrentPage" :page-size="10" layout="total, prev, pager, next" :total="DrawResultTotal">
            </el-pagination>
        </div>
    </el-dialog>
</el-row>
</template>

<style>
.el-loading-mask {
    background-color: rgba(11, 18, 71, .7);
}
</style>

<style scoped>
.lottery-content {
    margin-top: 5px;
    height: 69%;
}

.lottery-content-right {
    background: rgb(84, 74, 144);
}

.lottery-content-left {
    min-height: 400px;
    height: 100%;
    padding: 2px;
    margin-right: 2px;
}

.lottery-content-left-content {
    height: 100%;
    border-radius: 10px;
    background: rgb(54, 44, 81);
    overflow: auto;
}

.lottery-content-left-content-item {
    height: 50px;
    line-height: 50px;
    text-align: center;
    color: rgb(255, 255, 255);
}

.lottery-content-left-content-item img {
    height: 30px;
    width: 30px;
    border-radius: 100%;
    margin-top: 10px;
}

.lottery-content-right {
    min-height: 400px;
    height: 100%;
    position: relative;
}


.lottery-content-result-clearup {
    border: rgb(255, 255, 255) solid 5px;
    border-radius: 10px;
    background: rgb(255, 241, 192);
    margin-left: 10%;
    margin-right: 10%;
    margin-top: 30%;
    text-align: center;
    color: rgb(86, 77, 141);
}

.lottery-content-result-btn {
    margin-top: 60px;
}


/*=========================滑动===================================*/

 ::-webkit-scrollbar {
    width: 15px;
    background: rgba(54, 44, 81, .2);
}


/* 滚动槽 */

 ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    border-radius: 10px;
    background-color: rgba(84, 74, 144, 1);
}

/* 滚动条滑块 */

 ::-webkit-scrollbar-thumb {
    height: 20 p;
    border-radius: 20px;
    background: rgb(67, 53, 106);
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
}
</style>

<script>
export default {
    'name': 'DouyuDrawLottery',
    data() {
        return {
            lotteryUsers: [],
            loadingGifts: false,
            lotteryResult: '',
            scrollContent: null,
            dialogTableVisible: false,
            DrawResultCurrentPage: 1,
            DrawResultTotal: 0,
            DrawResultData: [],
            luckier: ''
        }
    },
    methods: {
        cleanData() {
            let _this = this
            _this.loadingGifts = true
            let luckPage = Math.ceil(this.lucknum / 1000)
            _this.axios.get('/lotteries/gifts/' + _this.voteId, {
                params: {
                    page: luckPage
                }
            }).then(function(response) {
                let resp = response.data
                if (resp.code) {
                    _this.lotteryUsers = resp.msg
                    let luckno = _this.lucknum % 1000
                    _this.luckier = resp.msg[luckno]
                } else {
                    _this.$message.error('数据错误')
                }
                _this.loadingGifts = false
            }).catch(function(response) {
                _this.$message.error('没有数据')
                _this.loadingGifts = false
            })
        },
        getLotteryResult() {
            let _this = this
            _this.dialogTableVisible = true
            this.axios.get('/lotteries/lucky/all').then(function(response) {
                let res = response.data
                if (res.code) {
                    _this.DrawResultData = res.msg.data
                    _this.DrawResultTotal = res.msg.total
                }
            })
        },
        DrawResultCurrentChange(val) {
            let _this = this
            _this.axios.get('/lotteries/lucky/all', {
                params: {
                    page: val
                }
            }).then(function(response) {
                let res = response.data
                if (res.code) {
                    _this.DrawResultData = res.msg.data
                }
            })
        }
    },
    props: [
        "voteId",
        "lucknum"
    ],
    mounted() {
        this.scrollContent = document.getElementById('lottery-content-left-content')
        this.cleanData()
    }
}
</script>
