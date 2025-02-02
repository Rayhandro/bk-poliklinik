@extends('layouts.master')
@section('title')
    Users Management
@endsection

@section('css')
    <link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ config('app.name') }}
        @endslot
        @slot('li_2')
            Users Management
        @endslot
        @slot('title')
            Users Management
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Users Management</h4>
                </div>
                <!--end card-header-->
                <div class="card-body table-responsive">
                    <div class="">
                        <table id="datatable" class="table dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalForm" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="modalFormLabel">Tambah User</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <div class="card-body p-0">
                        <div class="form-alert">

                        </div>
                        <form class="form-horizontal auth-form">
                            <input type="hidden" name="avatar">

                            <div class="form-group mb-2">
                                <label class="form-label" for="name">Nama</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Enter name">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Enter email">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Enter password">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" placeholder="Enter password confirmation">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label" for="mobilenumber">Nomor Telepon</label>
                                <div class="input-group">
                                    <input type="tel" class="form-control" name="mobilenumber" id="mobilenumber"
                                        placeholder="Enter phone number">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label" for="role">Role</label>
                                <div class="input-group">
                                    <select class="form-control select2" name="role" id="role">
                                        <option value="admin">Admin</option>
                                        <option value="owner">Owner</option>
                                    </select>
                                </div>
                            </div>
                            <!--end form-group-->

                            <div class="form-group mb-0 row">
                                <div class="col-12">
                                    <input type="hidden" name="id" id="id" value="">
                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Submit <i
                                            class="fas fa-save ms-1"></i></button>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end form-group-->
                        </form>
                    </div>
                    <!--end card-body-->
                    <div class="card-body bg-light-alt text-center">
                        <span class="text-muted d-none d-sm-inline-block">{{ config('app.name') }} ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                        </span>
                    </div>
                </div>
                <!--end modal-body-->

            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
    <!--end modal-->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>

    <script>
        "use strict";
        var type_id = "";

        var datatable = function() {
            var table = $('#datatable').DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: `${HOST_URL}/users/data`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'id',
                        responsivePriority: -1
                    }
                ],
                columnDefs: [{
                        targets: -1,
                        render: function(data, type, row) {
                            let json_row = JSON.stringify(row);
                            return `
                                    <button class="btn btn-sm btn-soft-danger btn-destroy" data-id="${data}"><i class="fas fa-trash"></i></button>`;
                        }
                    },
                    {
                        targets: 0,
                        render: function(data, type, row) {
                            return moment(data).format('DD MMMM YYYY HH:mm:ss');
                        }
                    }
                ],
            });

            return {
                init: function() {
                    table;
                },
                reload: function() {
                    table.ajax.reload();
                }
            };

        }();

        jQuery(document).ready(function() {
            datatable.init();

            $(".select2").select2({
                width: '100%',
                dropdownParent: $("#modalForm")
            });

            $('.btn-create').on('click', function() {
                $('#id').val('');
                $('#modalForm form')[0].reset();
                $('.modal-title').text('Tambah Data');
                $('#modalForm').modal('show');
            });

            $('#modalForm form').on('submit', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? `${HOST_URL}/users/${id}` : `${HOST_URL}/users`;
                let method = id ? 'PUT' : 'POST';
                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        $('#modalForm').modal('hide');
                        datatable.reload();
                        Swal.fire({
                            title: 'Success!',
                            text: res.message,
                            icon: 'success',
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    error: function(err) {
                        Swal.fire({
                            title: 'Error!',
                            text: err.responseJSON.message,
                            icon: 'error',
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });

                        let errors = err.responseJSON.errors;
                        $('.form-alert').html('');
                        $.each(errors, function(key, value) {
                            $('.form-alert').append(`<div class="mb-3 alert custom-alert custom-alert-danger icon-custom-alert shadow-sm fade show d-flex justify-content-between mb-0" role="alert">
                                <div class="media">
                                    <i class="la la-skull-crossbones alert-icon text-danger align-self-center font-30 me-3"></i>
                                    <div class="media-body align-self-center">
                                        <h5 class="mb-1 fw-bold mt-0">${key}</h5>
                                        <span>${value}</span>
                                    </div>
                                </div>
                                <button type="button" class="btn-close align-self-center" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`);
                        });
                    }
                });
            });

            $('#datatable').on('click', '.btn-edit', function() {
                let row = $(this).data('row');
                $('#modalForm form')[0].reset();
                $('.modal-title').text('Edit Data: ' + row.name);
                $('#modalForm').modal('show');
                $('#id').val(row.id);
                $('#name').val(row.name);
                $('#email').val(row.email);
                $('#role').val(row.role).trigger('change');
                $('#mobilenumber').val(row.mobilenumber);
                $('#age').val(row.age);
                $('#gender').val(row.gender).trigger('change');
                $('#address').val(row.address);

            });

            $('#datatable').on('click', '.btn-destroy', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: `${HOST_URL}/users/${id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                                datatable.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
