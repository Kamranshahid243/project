<a href="{{ url('/logout') }}"
    onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
    <i class="fa fa-sign-out-alt"></i>
    <span>Logout</span>
</a>

<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>