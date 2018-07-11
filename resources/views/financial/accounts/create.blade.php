@extends('layouts.admin.dashboard')

@section('title', 'New User')

@section('main-content')

    <div id="app">
    @include('layouts.admin.partials.toast')

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
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="form-line" :class="{'error': errors.name}">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" class="form-control" aria-invalid="true" v-model="employee.name" placeholder="Name" />
                                    </div>
                                    <label class="error" for="name" v-for="error in errors.name">@{{ error }}</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="form-line" :class="{'error': errors.email}">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" class="form-control" v-model="employee.email" placeholder="Email" />
                                    </div>
                                    <label class="error" for="email" v-for="error in errors.email">@{{ error }}</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success pull-right" @click="saveEmployee">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Widgets -->
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                employee: {
                    name: "",
                    email: ""
                },
                errors: [],
                message: ""
            },

            methods: {
                saveEmployee: function() {

                    this.errors = [];

                    axios.post('/api/employees/', this.employee).then(response => {
                        this.employee.name = '';
                        this.employee.email = '';

                        this.message = "User created successfully";

                        let inst = this;

                        setTimeout(function () {
                            inst.message = "";
                        }, 3000);
                    }).catch(error => {
                        this.errors = error.response.data.errors;

                    })
                }
            },

            mounted: function () {

            }
        })
    </script>
@endsection
