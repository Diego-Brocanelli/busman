@extends('layouts.admin.dashboard')

@section('title', 'Users')

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
                            <a href="{{ route('users.create') }}" class="btn btn-xs btn-success pull-right" style="margin-right: 5px">New</a>
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
                        <div class="col-md-2">
                            <div class="input-group">
                                        <span class="input-group-addon">
                                            Per page:
                                        </span>
                                <div class="form-line">
                                    <select class="form-control show-tick" v-model="per_page" @change="getEmployees">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 pull-right">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" v-model="search_query" @keyup="search" placeholder="Search">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="overflow-x: scroll; width: auto; white-space: nowrap;">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <td>Name</td>
                                <td>Email</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="employee in employees">
                                <td>@{{ employee.user.name }}</td>
                                <td>@{{ employee.user.email }}</td>
                                <td>
                                    <div class="btn-group-xs pull-right">
                                        <a class="btn btn-default" :href="'/users/' + employee.id" title="Detail"><i class="pe-7s-look"></i></a>
                                        <a class="btn btn-info" :href="'/users/' + employee.id + '/edit'" title="Edit"><i class="pe-7s-edit"></i></a>
                                        <a class="btn btn-danger" @click="deleteEmployee(employee)"><i class="pe-7s-close" title="Delete"></i></a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Displaying from @{{ from }} to @{{ to }} of @{{ total }}
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group-xs pull-right">
                                <span v-for="page in pages">
                                    <button class="btn btn-info" v-if="page == current_page" @click="goToPage(page)">@{{ page }}</button>
                                    <button class="btn btn-default" v-else @click="goToPage(page)" style="margin-right: 2px">@{{ page }}</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                employees: [],
                total: 1,
                current_page: 1,
                limit: 10,
                last_page: 1,
                from: 1,
                to: 1,
                per_page: 10,
                maxVisibleButtons: 3,
                pages: [],
                search_query: '',
                timeout: null
            },

            methods: {
                getEmployees: function () {
                    axios.get('/api/employees?limit=' + this.per_page + '&page=' + this.current_page + '&q=' + this.search_query).then(response => {
                        let data = response.data;

                        this.employees = data.data;

                        this.total = data.total;

                        this.current_page = data.current_page;

                        this.from = data.from;

                        this.to = data.to;

                        this.pages = [];

                        for (let i = 1; i <= data.last_page; i++) {

                            if (i == 1) {
                                this.pages.push(i);

                                if (data.last_page > 6 && this.current_page > 4){
                                    this.pages.push('...');
                                }

                            } else if (i == data.current_page){
                                this.pages.push(i);
                            } else if (i == data.last_page){

                                if (data.last_page > 6 && this.current_page < data.last_page - 3){
                                    this.pages.push('...');
                                }

                                this.pages.push(i);
                            } else if (data.last_page > 6){
                                if (i >= this.current_page - 2 && i < this.current_page ) {
                                    this.pages.push(i)
                                }

                                if (i <= this.current_page + 2 && i > this.current_page ) {
                                    this.pages.push(i)
                                }
                            }
                        }
                    })
                },

                search: function(){
                    clearTimeout(this.timeout);

                    this.timeout = setTimeout(() => {
                        this.getEmployees();
                    }, 300);
                },

                goToPage: function(page) {
                    if (page !== '...') {
                        this.current_page = page;
                        this.getEmployees();
                    }
                },

                deleteEmployee: function (employee) {
                    let inst = this;
                    swal({
                        title: "Are you sure?",
                        text: "Delete user: " + employee.user.name,
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                    }, function () {

                        axios.delete('/api/employees/' + employee.id).then(response => {

                            inst.getEmployees();

                            swal({
                                type: "success",
                                title: "User deleted successfully",
                                timer: 300
                            });
                        })

                    })
                }
            },

            mounted: function (){
                this.getEmployees();
            }
        })
    </script>
@endsection
