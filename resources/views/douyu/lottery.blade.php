@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">抽奖列表</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($vote_times as $vote_time)
                                <li class="list-group-item clearfix">
                                    {{ ((isset($_REQUEST['page'])?$_REQUEST['page']:1)-1)*15 + $loop->index + 1 }}.开始时间：
                                    <span style="color: rgb(199,37,78);">{{ $vote_time->start_time }}</span>
                                    ~  结束时间：
                                    <span style="color: rgb(199,37,78);">{{  $vote_time->end_time }}</span>
                                    @if($vote_time->is_draw) <span class="text-danger">(已抽过)</span>
                                    <a href=" {{ route('lottery.show',['lottery' => $vote_time->vote_id]) }} "
                                       class="btn btn-info pull-right" role="button">查看</a>
                                    @else
                                        <a href=" {{ route('lottery.show',['lottery' => $vote_time->vote_id]) }} "
                                           class="btn btn-success pull-right" role="button">抽奖</a>
                                    @endif
                                </li>
                            @endforeach
                            {{ $vote_times->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
