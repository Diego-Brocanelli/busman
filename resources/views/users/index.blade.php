@extends('layouts.admin.dashboard')

@section('title', 'Users')

@section('main-content')
    <div id="app" >
        <transition name="slide-fade">
            <div v-if="message" class="alert alert-success alert-dismissible" style="position: absolute; right: 50px; top: 50px; z-index: 100000">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                @{{ message }}
            </div>
        </transition>

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
                    </div>
                    <div class="body">

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
                                    <td @click="orderBy('user.name')">
                                        <strong>Name</strong>
                                        <i class="pe-7s-angle-up pull-right pe-2x" v-if="sort_by == 'user.name'"></i>
                                        <i class="pe-7s-angle-down pull-right pe-2x" v-if="sort_by_desc == 'user.name'"></i>
                                    </td>
                                    <td @click="orderBy('user.email')">
                                        <strong>Email</strong>
                                        <i class="pe-7s-angle-up pull-right pe-2x" v-if="sort_by == 'user.email'"></i>
                                        <i class="pe-7s-angle-down pull-right pe-2x" v-if="sort_by_desc == 'user.email'"></i>
                                    </td>
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
                timeout: null,
                message: "",

                sort_by: 'user.name',
                sort_by_desc: '',
            },

            methods: {
                getEmployees: function (sort_by = false) {

                    let sort = '&sort_by=' + this.sort_by;

                    if (this.sort_by_desc) {
                        sort = '&sort_by_desc=' + this.sort_by_desc
                    }

                    axios.get('/api/employees?limit=' + this.per_page + '&page=' + this.current_page + sort + '&q=' + this.search_query).then(response => {
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
                        confirmButtonColor: '#e10000',
                        confirmButtonText: 'Yes, delete it'
                    }, function () {

                        axios.delete('/api/employees/' + employee.id).then(response => {

                            inst.getEmployees();

                            inst.message = "User deleted successfully";

                            setTimeout(function () {
                                inst.message = "";
                            }, 3000);
                        })

                    })
                },

                orderBy: function (column) {
                    if (this.sort_by == column) {
                        this.sort_by = '';
                        this.sort_by_desc = column;
                    } else {
                        this.sort_by = column;
                        this.sort_by_desc = '';
                    }

                    this.getEmployees();
                }
            },

            mounted: function (){
                this.getEmployees();
            }
        })
    </script>
@endsection
