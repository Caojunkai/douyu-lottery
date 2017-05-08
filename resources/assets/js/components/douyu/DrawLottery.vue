<template>
<el-row class="lottery-content">
    <el-col :span="6" :offset="4" class="lottery-content-left" v-loading="loadingGifts" element-loading-text="拼命加载中">
        <div class="grid-content lottery-content-left-content" id="lottery-content-left-content">
            <ul>
                <li v-for="lotteryUser in lotteryUsers">
                    {{ lotteryUser.douyu_name }} {{ lotteryUser.vote_time }}
                </li>
            </ul>
        </div>
    </el-col>
    <el-col :span="10" class="lottery-content-right" v-loading="loading" element-loading-text="拼命加载中">
        <div class="block">
            <div class="lottery-content-result">
                <transition name="bounce">
                    <div class="lottery-content-result-clearup" v-show="clearResult">
                        <h2>{{ lotteryResult }}</h2>
                    </div>
                </transition>

            </div>
            <div class="lottery-content-right-button">
                <el-row>
                    <el-col :span="4" :offset="6">
                        <el-button type="warning" size="large" @click="cleanData" class="lottery-content-right-button-left">去除无用数据</el-button>
                    </el-col>
                    <el-col :span="4" :offset="4">
                        <el-button type="info" size="large" @click="lottery" class="lottery-content-right-button-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;开始抽奖&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</el-button>
                    </el-col>
                </el-row>
            </div>
        </div>
    </el-col>
</el-row>
</template>

<style scoped>
.lottery-content {
    margin-top: 5px;
    height: 69%;
}

.el-col {
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

.lottery-content-left-content ul {
    padding-left: 0;
}

.lottery-content-left-content li {
    list-style: none;
    color: white;
    padding: 3px;
    width: 100%;
    text-align: center;
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

.lottery-content-result {}

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
    height: 20p;
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
            getDataKind: 0
        }
    },
    methods: {
        lottery() {
            this.clearResult = false
        },
        getGifts() {
            let _this = this;
            _this.loadingGifts = true
            this.axios.get('/lotteries/' + _this.voteId, {
                params: {
                    page: _this.pageId
                }
            }).then(function(response) {
                let resp = response.data
                if (resp.code) {
                    let res = JSON.parse(resp.msg)
                    _this.pageId = parseInt(res.current_page) + 1
                    _this.lotteryUsers = _this.lotteryUsers.concat(res.data)
                }
                _this.loadingGifts = false
            })
        },
        getMoreGifts() {
            if (this.scrollContent.scrollTop + this.scrollContent.offsetHeight >= this.scrollContent.scrollHeight) {
                if (this.getDataKind) {
                    this.cleanData()
                } else {
                    this.getGifts()
                }
            }
        },
        cleanData() {
            let _this = this
            if (!_this.getDataKind) {
                _this.pageId = 1
            }
            if(_this.pageId > 1){
                _this.loadingGifts = true
            }else{
                _this.loading = true
            }
            _this.getDataKind = 1
            _this.axios.get('/lotteries/gifts/' + _this.voteId,{
                params: {
                    page: _this.pageId
                }
            }).then(function(response) {
                let resp = response.data
                if (resp.code) {
                    let res = JSON.parse(resp.msg)
                    if (_this.getDataKind == 0 && _this.getLotteryUsersLen) {
                        _this.lotteryUsers = []
                    }
                    _this.lotteryUsers = _this.lotteryUsers.concat(res)
                    if(_this.pageId > 1){
                        _this.loadingGifts = false
                    }else{
                        _this.loading = false
                        _this.clearResult = true
                        _this.lotteryResult = '无效数据清理完成'
                    }
                    _this.pageId++
                }
            })
        },
        drawLuckier() {
            let _this = this
            _this.loading = true
            _this.axios.post('/lottery/draw', {
                lottery_vote_id: _this.voteId
            }).then(function(response) {
                if (response.code) {
                    //TODO 中奖用户
                    _this.loading = false
                }
            })
        }
    },
    props: [
        "voteId"
    ],
    computed: {
        getLotteryUsersLen() {
            return (this.lotteryUsers.length > 0)
        }
    },
    mounted() {
        this.scrollContent = document.getElementById('lottery-content-left-content')
        this.getGifts(1)
        this.scrollContent.addEventListener('scroll', this.getMoreGifts);
    }
}
</script>
