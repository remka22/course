@extends('layouts.schedule_layout')

@section('content')
    <form id="formAction" method="POST" action="{{ route('more_inf_record_post') }}">
        @csrf
        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="col-7 d-flex m-2 p-3 flex-column">
                    <div class="card">
                        <h5 class="card-header">Запись</h5>
                        <div class="card-body">
                            <input id="record" name="record" style="display: none" value="{{ $record->id }}">
                            <input id="date" name="date" style="display: none" value="{{ $date->id }}">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row-2">Дата и время:</th>
                                        <td>{{ $date->date }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Клиент:</th>
                                        <td>{{ $client->fio }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Номер телефона:</th>
                                        <td>{{ $client->number }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Автомобиль:</th>
                                        <td>{{ $car->mark }} {{ $car->model }} {{ $car->gos_number }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Описание:</th>
                                        <td>
                                            {{ $record->description }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Статус:</th>
                                        <td>
                                            <div class="col-6">
                                                @if ($record->status == 2)
                                                <select id="selectStatus" onchange="saveMode()" required
                                                        name="selectStatus" class="form-select mb-1" disabled
                                                        aria-label="Default select example">
                                                @else
                                                    <select id="selectStatus" onchange="saveMode()" required
                                                        name="selectStatus" class="form-select mb-1"
                                                        aria-label="Default select example">
                                                @endif
                                                @if ($actual)
                                                    <option value="0">ожидается</option>
                                                @else
                                                    <option value="1">выполнено</option>
                                                @endif
                                                <option value="2">неявка</option>
                                                </select>
                                                <script>
                                                    var record = @json($record, JSON_UNESCAPED_UNICODE);
                                                    const select = document.getElementById('selectStatus');
                                                    select.value = record['status'];
                                                </script>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="col d-flex align-items-center justify-content-center mt-3">
                                <a id="back" onclick="history.back();"
                                    class="btn btn-primary me-3 mb-1">Назад</a>
                                <button id="save" href="#" class="btn btn-primary  mb-1"
                                    style="display: none">Подтвердить выполнение</button>
                                <a id="saveCancel" class="btn btn-primary me-3 mb-1" data-bs-toggle="modal"
                                    data-bs-target="#cancelModal" style="display: none">Подтвердить
                                    неявку клиента</a>
                                <!-- cancelModal -->
                                <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cancelModalLabel">Внимение!</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <h4 class="ms-2">Вы действительно хотите установить статус неявка?</h4>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row-2">Дата и время:</th>
                                                            <td>{{ $date->date }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Клиент:</th>
                                                            <td>{{ $client->fio }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Автомобиль:</th>
                                                            <td>{{ $car->mark }} {{ $car->model }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="sumbit" class="btn btn-secondary">Да</button>
                                                <a data-bs-dismiss="modal" class="btn btn-primary">Нет, назад</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

<script>
    function saveMode() {
        const back = document.getElementById('back')
        const save = document.getElementById('save')
        const saveCancel = document.getElementById('saveCancel')
        var record = @json($record, JSON_UNESCAPED_UNICODE);

        const select = document.getElementById('selectStatus');
        if (select.value == record['status'] || select.value == 0) {
            save.style.display = "none";
            saveCancel.style.display = 'none';
        } else if (select.value == 1) {
            save.style.display = "block";
            saveCancel.style.display = 'none';
        } else if (select.value == 2) {
            save.style.display = "none";
            saveCancel.style.display = 'block';
        }


    }
    // window.onbeforeunload = function() {
    //     return "Вы изменили статус, не забудьте его сохранить!";
    // };
</script>
