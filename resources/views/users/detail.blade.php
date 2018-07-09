@extends('layouts.admin.dashboard')

@section('title', 'User Detail')

@section('main-content')
    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-6">
                            <h2>@yield('title')</h2>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <a href="{{ route('users.list') }}" class="btn btn-xs btn-success pull-right" style="margin-right: 5px">Back to List</a>
                        </div>
                    </div>
                    {{--<ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('users.create') }}" class=" waves-effect waves-block">New</a></li>
                            </ul>
                        </li>
                    </ul>--}}
                </div>
                <div id="app" class="body">
                    <div class="row">
                        <div class="col-md-5">
                            Name: @{{ employee.user.name }}
                        </div>
                        <div class="col-md-5">
                            Email: @{{ employee.user.email }}
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-success" :href="'/users/' + employee.id + '/edit'">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->
@endsection

@section('scripts')
    @parent

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                employee: {
                    user: {
                        id: "",
                        name: "",
                        email: ""
                    }
                },
            },

            methods: {
                getEmployee: function() {
                    axios.get('/api/employees', this.employee).then(response => {
                        console.log(response.data)
                    });
                }
            },

            mounted: function (){
                let params = location.href.split('/');

                axios.get('/api/employees/' + params[params.length - 1]).then(response => {
                    this.employee = response.data;
                });
            }
        })
    </script>
@endsection
