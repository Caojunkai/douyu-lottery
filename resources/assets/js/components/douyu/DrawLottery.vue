<template>
<el-row class="lottery-content">
    <el-col :span="8" :offset="4" class="lottery-content-left" v-loading="loadingGifts" element-loading-text="拼命加载中">
        <div class="grid-content lottery-content-left-content" id="lottery-content-left-content">
            <div v-for="lotteryUser in lotteryUsers" :key="lotteryUser.cid" class="lottery-content-left-content-item">
                <el-row v-if="lotteryUser.cid === lucknum" style="border:2px dashed #13ce66">
                    <el-col :span="2">{{lotteryUser.cid}}</el-col>
                    <el-col :span="4">
                        <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1494331517247&di=da53acca7260e0770a6424779497126b&imgtype=0&src=http%3A%2F%2Fpic2.orsoon.com%2F2016%2F1215%2F20161215100547239.jpg">
                    </el-col>
                    <el-col :span="9">{{ lotteryUser.douyu_name | subName }}</el-col>
                    <el-col :span="9">{{ lotteryUser.vote_time | subTime }}</el-col>
                </el-row>
                <el-row v-else>
                    <el-col :span="2">{{lotteryUser.cid}}</el-col>
                    <el-col :span="4">
                        <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1494331517247&di=da53acca7260e0770a6424779497126b&imgtype=0&src=http%3A%2F%2Fpic2.orsoon.com%2F2016%2F1215%2F20161215100547239.jpg">
                    </el-col>
                    <el-col :span="9">{{ lotteryUser.douyu_name | subName }}</el-col>
                    <el-col :span="9">{{ lotteryUser.vote_time | subTime}}</el-col>
                </el-row>
            </div>
        </div>
    </el-col>
    <el-col :span="8" class="lottery-content-right" v-loading.fullscreen="loading" element-loading-text="拼命加载中">
        <div class="block">
            <div class="lottery-content-result">
                <el-alert v-show="!clearResult" title="请先清理数据" type="warning">
                </el-alert>
                <transition name="bounce">
                    <div class="lottery-content-result-clearup" v-show="clearResult" v-html="lotteryResult"></div>
                </transition>
            </div>
            <div class="lottery-content-right-button">
                <el-row>
                    <el-col :span="5" :offset="5">
                        <el-button type="warning" :disabled="cleanDataBtn" size="large" @click="cleanData" class="lottery-content-right-button-left">去除无用数据
                        </el-button>
                    </el-col>
                    <el-col :span="5" :offset="3">
                        <el-button type="info" size="large" :disabled="drawLuckierBtn" @click="drawLuckier" class="lottery-content-right-button-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;开始抽奖&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </el-button>
                    </el-col>
                </el-row>
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

.lottery-content-right-button {
    position: absolute;
    bottom: 20px;
    width: 100%;
    display: block;
}

.lottery-content-right-button-left {
    background: rgb(255, 228, 1);
    color: rgb(54, 45, 81);
    font-weight: 600;
    border: none;
    box-shadow: 0px 6px 2px rgb(198, 161, 32), 0px 9px 25px rgba(0, 0, 0, .7);
    -webkit-transition: all .1s ease;
    -moz-transition: all .1s ease;
    transition: all .1s ease;
    position: relative;
}

.lottery-content-right-button-left:active {
    box-shadow: 0px 3px 3px rgb(198, 161, 32), 0px 3px 6px rgba(0, 0, 0, .9);
    position: relative;
    top: 6px;
}

.lottery-content-right-button-right {
    background: rgb(29, 234, 173);
    color: rgb(54, 45, 81);
    font-weight: 600;
    border: none;
    box-shadow: 0px 6px 2px rgb(20, 167, 156), 0px 9px 25px rgba(0, 0, 0, .7);
    -webkit-transition: all .1s ease;
    -moz-transition: all .1s ease;
    transition: all .1s ease;
    position: relative;
}

.lottery-content-right-button-right:active {
    box-shadow: 0px 2px 3px rgb(20, 167, 156), 0px 3px 6px rgba(0, 0, 0, .9);
    position: relative;
    top: 6px;
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




/*过渡效果
                    =============================================================
                    */

.bounce-enter-active {
    animation: bounce-in .5s;
}

.bounce-leave-active {
    animation: bounce-out .5s;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.5);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes bounce-out {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.5);
    }
    100% {
        transform: scale(0);
    }
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
            clearResult: false,
            loading: false,
            loadingGifts: false,
            lotteryResult: '',
            scrollContent: null,
            pageId: 1,
            lotteryUsersLen: 0,
            getDataKind: 0,
            cleanDataBtn: false,
            drawLuckierBtn: false,
            luckier: null,
            hasData: true,
            DrawResultData: [],
            dialogTableVisible: false,
            DrawResultCurrentPage: 1,
            DrawResultTotal: 0,
            lucknum: null
        }
    },
    methods: {
        getGifts() {
            let _this = this;
            _this.loadingGifts = true
            this.axios.get( '/lotteries/' + _this.voteId, {
                params: {
                    page: _this.pageId
                }
            } ).then( function ( response ) {
                let resp = response.data
                if ( resp.code ) {
                    let res = resp.msg
                    _this.pageId = parseInt( res.current_page ) + 1
                    _this.lotteryUsers = _this.lotteryUsers.concat( res.data )
                } else {
                    _this.$message.warning( '没有数据了' )
                    _this.hasData = false
                }
                _this.loadingGifts = false
            } ).catch( function ( response ) {
                _this.loadingGifts = false
                _this.$message.warning( '数据错误' )
            } )
        },
        getMoreGifts() {
            if ( this.scrollContent.scrollTop + this.scrollContent.offsetHeight >= this.scrollContent.scrollHeight ) {
                if ( this.hasData ) {
                    if ( this.getDataKind ) {
                        this.cleanData()
                    } else {
                        this.getGifts()
                    }
                } else {
                    this.$message.error( '没有数据了' )
                }
            }
        },
        cleanData() {
            let _this = this
            if ( !_this.getDataKind ) {
                _this.pageId = 1
                _this.hasData = true
            }
            if ( _this.pageId > 1 ) {
                _this.loadingGifts = true
            } else {
                _this.loading = true
            }
            _this.axios.get( '/lotteries/gifts/' + _this.voteId, {
                params: {
                    page: _this.pageId
                }
            } ).then( function ( response ) {
                let resp = response.data
                if ( resp.code ) {
                    if ( _this.getLotteryUsersLen && !_this.getDataKind ) {
                        _this.lotteryUsers = []
                    }
                    _this.getDataKind = 1
                    _this.lotteryUsers = _this.lotteryUsers.concat( resp.msg )
                    if ( _this.pageId > 1 ) {
                        _this.loadingGifts = false
                    } else {
                        _this.scrollContent.scrollTop = 0
                        _this.loading = false
                        _this.clearResult = true
                        _this.lotteryResult = '<h1>无效数据清理完成,请开始抽奖</h1>'
                    }
                    _this.pageId++
                        _this.cleanDataBtn = true
                } else {
                    _this.$message.warning( '没有数据了' )
                    _this.hasData = false
                    _this.loading = false
                    _this.loadingGifts = false
                }
            } ).catch( function ( response ) {
                _this.$message.error( '没有数据了' )
                _this.loading = false
                _this.loadingGifts = false
            } )
        },
        drawLuckier() {
            let _this = this
            if ( _this.clearResult ) {
                _this.loading = true
                _this.axios.post( '/lottery/draw', {
                    lottery_vote_id: _this.voteId
                } ).then( function ( response ) {
                    let res = response.data
                    if ( res.code ) {
                        //TODO 中奖用户
                        _this.axios.get( '/lotteries/gifts/' + _this.voteId, {
                            params: {
                                page: Math.ceil( parseInt( res.msg.lucknum ) / 1000 )
                            }
                        } ).then( function ( response ) {
                            let resp = response.data
                            if ( resp.code ) {
                                _this.lucknum = res.msg.lucknum
                                _this.lotteryUsers = resp.msg
                                _this.hasData = false
                                _this.scrollContent.scrollTop = _this.scrollContent.scrollHeight * ( ( res.msg.lucknum % 1000 ) / 1000 - 0.006 )
                            }
                        } )
                        _this.lotteryResult = '<h1>计算结果：<span style="color:red;">' + res.msg.lucknum + '</span></h1><h1>恭喜<span style="color:red;">' + res.msg.douyu_name + '</span>获奖</h1>'
                        _this.luckier = res.msg.douyu_name
                        // _this.$alert('获奖用户为:' + _this.luckier, '抽奖完成', {
                        //     confirmButtonText: '确定'
                        // });
                        _this.loading = false
                        _this.drawLuckierBtn = true
                    } else {
                        _this.$message.error( '抽奖失败，请重试' )
                        _this.loading = false
                    }
                } ).catch( function ( response ) {
                    _this.$message.error( '数据错误' )
                    _this.loading = false
                } )
            } else {
                _this.$message.error( '请先清理数据' )
            }
        },
        getLotteryResult() {
            let _this = this
            _this.dialogTableVisible = true
            this.axios.get( '/lotteries/lucky/all' ).then( function ( response ) {
                let res = response.data
                if ( res.code ) {
                    _this.DrawResultData = res.msg.data
                    _this.DrawResultTotal = res.msg.total
                }
            } )
            //TODO
        },
        DrawResultCurrentChange( val ) {
            let _this = this
            _this.axios.get( '/lotteries/lucky/all', {
                params: {
                    page: val
                }
            } ).then( function ( response ) {
                let res = response.data
                if ( res.code ) {
                    _this.DrawResultData = res.msg.data
                }
            } )
        }
    },
    props: [
        "voteId"
    ],
    computed: {
        getLotteryUsersLen() {
            return ( this.lotteryUsers.length > 0 )
        }
    },
    filters: {
        subName( val ) {
            return val.slice(0,8)
        },
        subTime(val){
            return val.slice(5,)
        }
    },
    mounted() {
        this.scrollContent = document.getElementById( 'lottery-content-left-content' )
        this.getGifts( 1 )
        this.scrollContent.addEventListener( 'scroll', this.getMoreGifts );
    }
}
</script>
