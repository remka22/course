@extends('layouts.schedule_layout')

@section('content')
    <form id="formAction" method="POST" action="{{ route('schedule') }}">
        <nav class="navbar navbar-expand-lg bg-light"
            style="position:fixed; top:0; width: 100%; overflow: hidden;background-color: #333;">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-2 mb-2 mb-lg-0">
                        <li class="nav-item">
                            <h4>Запись в автосервис</h4>
                        </li>
                    </ul>
                    <div class="d-flex col-8 justify-content-center">
                        {{-- <form id="formAction" method="POST" action="{{ route('schedule') }}"> --}}
                        @csrf
                        <div class="d-flex">
                            <div class="d-flex col-12 justify-content-center">
                                <input dusk="fio" name="fio" type="text" class="form-control me-2" placeholder="ФИО клиента"
                                    required value="{{ $fio }}">
                                <button name="find_record_fio_bt" class="btn btn-primary me-2" type="submit">Найти</button>
                            </div>
                            <div class="d-flex col-4">
                                <input onchange="redicect()" type="date" id="dateInput" value="{{ $dateInput }}"
                                    class="form-control me-2" name="date_finish" placeholder="Дата до">
                            </div>
                            @if ($statusPage == 'record')
                                <div class="d-flex col-4">
                                    <a href="/" class="btn btn-primary">Назад</a>
                                </div>
                            @endif
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </nav>


        <div class="container mt-5">
            <div class="d-flex align-items-center justify-content-center">
                <div class="col-8 d-flex flex-column">

                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <table class="table table-th-block " id="tableClient">
                            <thead>
                                <tr>
                                    <th>Время</th>
                                    <th>Информация</th>
                                    <th>Статус записи</th>
                                    <th>Действие</th>


                                </tr>
                            </thead>
                            <tbody id="tbody_contr">
                                @foreach ($dates as $date)
                                    @if ($date['actual'])
                                        <tr>
                                        @else
                                        <tr style="background: rgba(102, 102, 102, 0.2);">
                                    @endif
                                    @if ($date['status'] == 0)
                                        <td>
                                            <h5 class="mt-1">{{ $date['date'] }}</h5>
                                        </td>
                                        <td></td>
                                        <td>
                                            <h6 class="mt-2">{{ $date['statusStr'] }}<h6>
                                        </td>
                                        <td>
                                            <div>
                                                @if ($date['actual'])
                                                    <a dusk="recordBt{{ $date['id'] }}" href="record_appointment?id={{ $date['id'] }}"
                                                        class="btn btn-primary">Записать</a>
                                                @else
                                                    <h6 class="mt-2">Запись невозможна</h6>
                                                @endif
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <h5 class="mt-3">{{ $date['date'] }}</h5>
                                        </td>
                                        <td>
                                            <div class="d-flex mb-1 mt-2">
                                                <label class="me-2">Клиент: </label>
                                                <label><b>{{ $date['fio'] }}</b></label>
                                            </div>
                                            <div class="d-flex mb-2">
                                                <label class="me-2">Номер телефона:</label>
                                                <label><b>{{ $date['number'] }}</b></label>
                                            </div>
                                        </td>
                                        @switch($date['status_record'])
                                            @case(0)
                                                <td>
                                                    <h6 class="mt-3">Ожидается <i class="bi bi-clock"></i></h6>
                                                </td>
                                            @break

                                            @case(1)
                                                <td>
                                                    <h6 class="mt-3">Выполнено <i class="bi bi-check-square"></i>
                                                        <h6>
                                                </td>
                                            @break
                                        @endswitch
                                        <td>
                                            <div class="mt-2">
                                                <a href="more_inf_record?id={{ $date['id'] }}"
                                                    class="btn btn-primary">Подробнее</a>
                                            </div>
                                        </td>
                                    @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

<script>
    function redicect() {
        date = document.getElementById('dateInput')
        window.location = "/?date=" + date.value
    }
</script>
