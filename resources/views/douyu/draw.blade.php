@extends('layouts.app')
@section('content')
    <douyu-lottery-banner></douyu-lottery-banner>
    <douyu-draw-lottery vote-id="{{ $vote_id }}"></douyu-draw-lottery>
@endsection

<style>
    body{
        background: -webkit-linear-gradient(left, rgb(37, 24, 67) , rgb(9, 17, 71)); /* Safari 5.1 - 6.0 */
        background: -o-linear-gradient(right, rgb(37, 24, 67), rgb(9, 17, 71)); /* Opera 11.1 - 12.0 */
        background: -moz-linear-gradient(right, rgb(37, 24, 67), rgb(9, 17, 71)); /* Firefox 3.6 - 15 */
        background: linear-gradient(to right, rgb(37, 24, 67) , rgb(9, 17, 71)); /* 标准的语法 */
    }
</style>

