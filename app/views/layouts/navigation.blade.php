<style>
    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        font-size: 27px;
    }

    li {
        float: left;
        padding-right: 32px;
    }
</style>
<br>
<br>
<nav>
    <ul>
        <li><a href="{{ URL::route('readings') }}">数据</a></li>
        <li><a href="{{ URL::route('getThreshold') }}">查看合格线</a></li>
        <li><a href="{{ URL::route('devices') }}">查看传感装置</a></li>
        <li><a href="{{ URL::route('form') }}">设定合格线</a></li>
        <li><a href="{{ URL::route('records') }}">下载数据</a></li>
        <li><a href="{{ URL::route('account-phone') }}">修改报警电话</a></li>
        <li><a href="{{ URL::route('account-password') }}">修改密码</a></li>
        <li><a href="{{ URL::route('exhaustIndex') }}">Exhaust Index</a></li>
        <li><a href="{{ URL::route('exhaustRooms') }}">View Rooms</a></li>
        <li><a href="{{ URL::route('room_form') }}">Set Rooms</a></li>
        <li><a href="{{ URL::route('account-logoff') }}">退出</a></li>
    </ul>
</nav>
<br>
<br>
<br>
<br>
