@extends('layout')
@section('title')

    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection

@section('content')
    <section class="section">
        <div class="row justify-content-end p-4">
            <div class="col-lg-3">
                <a href="/admin/user/create" class="btn btn-success">
                    <i class="bi bi-file-earmark-plus"></i>&nbsp;
                    Добавить пользователя
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Список всех пользователей</h5>
                        <!-- Table with hoverable rows -->
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Имя пользователя</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user['id'] }}</th>
                                <td><h5>{{ $user['username'] }}</h5></td>
                                <td><h5>{{ $user['email'] }}</h5></td>
                                <td>
                                    <div class="btn-group" role="group" >
                                        <a class="btn btn-success"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           title="Edit"
                                           href="/admin/user/edit/{{ $user['id'] }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a class="btn btn-danger"
                                           data-bs-toggle="modal"
                                           data-bs-target="#modal-{{ $user['id'] }}"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           title="Delete"
                                           href="/admin/user/delete/{{ $user['id'] }}">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                        <div class="modal fade"
                                             id="modal-{{ $user['id'] }}"
                                             tabindex="-1" data-bs-backdrop="false"
                                        >
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Удаление</h5>
                                                        <button type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close">

                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Вы уверены что хотите удалить пользователя с ID
                                                        {{ $user['id'] }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Отменить
                                                        </button>
                                                        <a  href="/admin/user/delete/{{ $user['id']}}"
                                                            class="btn btn-primary">
                                                            Удалить
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End Disabled Backdrop Modal-->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with hoverable rows -->

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <!-- Disabled and active states -->
                        <nav aria-label="...">
                            <ul class="pagination">
                                {!! $pagination !!}
                            </ul>
                        </nav><!-- End Disabled and active states -->

                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection