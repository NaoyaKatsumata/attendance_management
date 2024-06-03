<nav x-data="{ open: false }" class="h-[100%] bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="h-[100%] content-center mx-auto">
        <div class="h-[100%] flex justify-between content-center items-center h-full">
                <div>
                    <a href="/" class="text-2xl px-5">Atte</a>
                </div>
            <ul class="flex content-center ">
                <li class="content-center px-5"><a href="/">ホーム</li>
                <li class="content-center px-5"><a href="/attendance">日付一覧</li>
                <li class="content-center px-5">
                    <form class="content-center" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')"
                            onclick="event.preventDefault();
                                this.closest('form').submit();">
                                        {{ __('ログアウト') }}
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    
</nav>
