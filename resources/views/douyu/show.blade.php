@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading"><span style="color: yellow;font-size: medium;">{{ $vote_time->start }}
                        ~ {{ $vote_time->end }}</span>时间段抽奖 以下
                        <span style="font-weight: bold;color: red">{{ $vote_list->total() }}</span> 用户获得抽奖资格
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            @foreach($vote_list as $vote)
                                <a href="#" class="list-group-item">
                                    <span class="list-group-item-text">{{ ((isset($_REQUEST['page'])?$_REQUEST['page']:1)-1)*15 + $loop->index + 1 }}.{{ $vote->douyu_name }}</span>
                                    <span class="pull-right">投票数量：<span class="text-danger" style="font-weight: bold">{{ $vote->total }}</span></span>
                                </a>
                            @endforeach
                        </div>
                        {{--{{ $vote_list->appends(['start' => base64_encode($vote_time->start),'end' => base64_encode($vote_time->end)])->links() }}--}}
                        {{ $vote_list->links() }}
                        <button class="btn btn-success btn-lg center-block" data-toggle="modal" data-target="#myModal">抽奖</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        请输入抽奖规则
                    </h4>
                </div>
                <form action="{{ route('lottery.store') }}" method="post" role="form">
                    <div class="modal-body">
                        <input type="hidden" name="lottery_vote_id" value="{{ $vote_id }}">
                        <input type="number" class="form-control" placeholder="输入获取抽奖资格所需礼物数 默认255" name="lottery_draw_rule">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <button type="submit" class="btn btn-primary">
                            点击抽奖
                        </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@endsection
