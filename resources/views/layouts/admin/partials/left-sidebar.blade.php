<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="/admin/images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</div>
            <div class="email">{{ auth()->user()->email }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="pe-7s-angle-down pe-2x" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);"><i class="pe-7s-user pe-2x pe-va"></i> Profile</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="pe-7s-users pe-2x pe-va"></i> Followers</a></li>
                    <li><a href="javascript:void(0);"><i class="pe-7s-cart pe-2x pe-va"></i> Sales</a></li>
                    <li><a href="javascript:void(0);"><i class="pe-7s-like pe-2x pe-va"></i> Likes</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="pe-7s-power pe-2x pe-va"></i> Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="{{ Route::current()->getPrefix() == '' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="pe-7s-home pe-2x pe-va"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="{{ Route::current()->getPrefix() == '/users' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="pe-7s-add-user pe-2x pe-va"></i>
                    <span>Users</span>
                </a>
                <ul class="ml-menu">
                    <li class={{ Route::current()->getName() == 'users.list' ? 'active' : '' }}>
                        <a href="{{ route('users.list') }}">
                            <i class="pe-7s-angle-right pe-2x pe-va"></i>
                            <span>List</span>
                        </a>
                    </li>
                    <li class="{{ Route::current()->getName() == 'users.create' ? 'active' : '' }}">
                        <a href="{{ route('users.create') }}">
                            <i class="pe-7s-angle-right pe-2x pe-va"></i>
                            <span>Create</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ Route::current()->getPrefix() == '/financial' ? 'active' : '' }}">
                <a href="#" class="menu-toggle">
                    <i class="pe-7s-cash pe-2x pe-va"></i>
                    <span>Financial</span>
                </a>
                <ul class="ml-menu">
                    <li class="{{ Route::current()->getName() == 'financial.incoming' ? 'active' : '' }}">
                        <a href="{{ route('financial.incoming') }}">
                            <i class="pe-7s-angle-right pe-2x pe-va"></i>
                            <span>Incoming</span>
                        </a>
                    </li>
                    <li class="{{ Route::current()->getName() == 'financial.expenses' ? 'active' : '' }}">
                        <a href="{{ route('financial.expenses') }}">
                            <i class="pe-7s-angle-right pe-2x pe-va"></i>
                            <span>Expenses</span>
                        </a>
                    </li>
                    <li class="{{ Route::current()->getName() == 'financial.accounts' ? 'active' : '' }}">
                        <a href="{{ route('financial.accounts') }}">
                            <i class="pe-7s-angle-right pe-2x pe-va"></i>
                            <span>Accounts</span>
                        </a>
                    </li>
                    <li class="{{ Route::current()->getName() == 'financial.balance' ? 'active' : '' }}">
                        <a href="{{ route('financial.balance') }}">
                            <i class="pe-7s-angle-right pe-2x pe-va"></i>
                            <span>Balance</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ Route::current()->getPrefix() == '/settings' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="pe-7s-config pe-2x pe-va"></i>
                    <span>Settings</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="#">
                            <i class="pe-7s-angle-right pe-2x pe-va"></i>
                            <span>Incoming</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="pe-7s-angle-right pe-2x pe-va"></i>
                            <span>Incoming</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2018 <a href="javascript:void(0);">{{ config('app.name') }}</a>
        </div>
    </div>
    <!-- #Footer -->
</aside>
