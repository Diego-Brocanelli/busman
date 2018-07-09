<!DOCTYPE html>
<html>

@include('layouts.admin.partials.head')

<body class="theme-purple">
    <!-- Page Loader -->
    @include('layouts.admin.partials.loader')
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Search Bar -->
    @include('layouts.admin.partials.search-bar')
    <!-- #END# Search Bar -->

    <!-- Top Bar -->
    @include('layouts.admin.partials.nav')
    <!-- #Top Bar -->

    <section>
        <!-- Left Sidebar -->
        @include('layouts.admin.partials.left-sidebar')
        <!-- #END# Left Sidebar -->

        <!-- Right Sidebar -->
        @include('layouts.admin.partials.right-sidebar')
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>@yield('title')</h2>
            </div>

            <!-- Main Content -->
            @yield('main-content')
            <!-- #END# Main Content -->

        </div>
    </section>

    @include('layouts.admin.partials.footer')

</body>

</html>
