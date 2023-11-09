{% extends "layout.twig" %}

{% block title %}

    <li class="breadcrumb-item active">{{ title }}</li>
{% endblock %}

{% block content %}
    <section class="section">
        <div class="row justify-content-end p-4">
            <div class="col-lg-3">
                <a href="/admin/article/create" class="btn btn-success">
                    <i class="bi bi-file-earmark-plus"></i>&nbsp;
                    Добавить статью
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Список всех статей</h5>
                        <!-- Table with hoverable rows -->
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Заголовок</th>
                                <th scope="col">Изоброжение</th>
                                <th scope="col">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for article in articles %}
                            <tr>
                                <th scope="row">{{ article.id }}</th>
                                <td>{{ article.title }}</td>
                                <td>
                                    <img src="{{ article.image }}" alt="" class="img-fluid">
                                </td>
                                <td>
                                    <div class="btn-group" role="group" >
                                        <a class="btn btn-success"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           title="Edit"
                                           href="/admin/article/edit/{{ article.id }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a class="btn btn-danger"
                                           data-bs-toggle="modal"
                                           data-bs-target="#modal-{{ article.id }}"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           title="Delete"
                                           href="/admin/article/delete/{{ article.id }}">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                        <div class="modal fade"
                                             id="modal-{{ article.id }}"
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
                                                        Вы уверены что хотите удалить статью с ID
                                                        {{ article.id }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Отменить
                                                        </button>
                                                        <a  href="/admin/article/delete/{{ article.id}}"
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
                            {% endfor %}
                            </tbody>
                        </table>
                        <!-- End Table with hoverable rows -->

                    </div>
                </div>


            </div>
        </div>
    </section>
{% endblock %}