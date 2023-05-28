@extends('layouts.schedule_layout')

@section('content')
    <form id="formAction" method="POST" action="{{ route('add_record_post') }}">
        @csrf
        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="col-5 d-flex m-2 p-3 flex-column"
                    style="border: 1px solid rgb(233, 233, 233); border-radius: .75rem">
                    <div class="col d-flex align-items-center justify-content-center mb-2">
                        <div class="me-2 mb-1">Запись на:</div>
                        <label class="form-control" style="width: 150px">{{ $date->date }}</label>
                        <input id="new" name="new" style="display: none" value="{{ $new }}">
                        <input id="id" name="id" style="display: none" value="{{ $date->id }}">
                    </div>
                    {{--  --}}
                    <div class="col d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="btn btn-outline-primary active  mb-1" id="client_find_menu_bt"
                            onclick='showFindClient("find")'>Выбрать
                            клиента</a>
                        <div class=" mb-1 ms-3 me-3">или</div>
                        <a href="#" dusk="new_client" class="btn btn-outline-primary mb-1" id="client_add_menu_bt"
                            onclick='showFindClient("add")'>Новый
                            клиент</a>
                    </div>
                    {{--  --}}
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="client_find" id="client_find" type="text" class="form-control me-1 mb-1"
                            placeholder="Введите ФИО клиента" value="{{ $fio }}">
                        <a onclick="setFind()" class="btn btn-primary  mb-1" id="client_find_bt">Найти</a>
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <div class=" mb-1 me-1" id="label_client">Клиент:</div>
                        <select onchange="setSelect()" required name="select_client" class="form-select mb-1"
                            aria-label="Default select example" id="select_client">
                        </select>
                        <script>
                            var select_client = document.getElementById("select_client");
                            var clients = @json($clients, JSON_UNESCAPED_UNICODE);
                            if (clients != null)
                                for (i = 0; i < clients.length; i++) {
                                    var option = document.createElement('option');
                                    option.value = clients[i]['id'];
                                    option.innerHTML = clients[i]['fio']
                                    select_client.appendChild(option);
                                }
                        </script>
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <div id="new_car_div" class=" mb-1 me-1" id="label_car">Автомобиль:</div>
                        <select required name="select_car" class="form-select  mb-1" aria-label="Default select example"
                            id="select_car">
                            <option></option>
                        </select>
                        <script>
                            var cars = @json($cars, JSON_UNESCAPED_UNICODE);
                            if (cars != null) {
                                var id = select_client.options[select_client.selectedIndex].value;
                                select_car.options.length = 0;
                                for (i = 0; i < cars.length; i++) {
                                    if (cars[i]['id_client'] == id) {
                                        var option = document.createElement('option');
                                        option.value = cars[i]['id'];
                                        option.innerHTML = cars[i]['mark'] + " " + cars[i]['model'];
                                        select_car.appendChild(option);
                                    }
                                }
                            }
                        </script>
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="add_mark" id="add_mark" type="text" class="form-control mb-1"
                            placeholder="Марка автомобиля" style="display: none">
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="add_model" id="add_model" type="text" class="form-control mb-1"
                            placeholder="Модель автомобиля" style="display: none">
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="add_gos_number" id="add_gos_number" type="text" class="form-control  mb-1"
                            placeholder="Гос. номер автомобиля" style="display: none">
                    </div>
                    <div class="col d-flex align-items-center justify-content-start">
                        <input name="cbAddCar" onchange="showAddCar()" class="form-check-input me-1" type="checkbox"
                            value="" id="cbNewCar">
                        <label id="new_car_label" class="form-check-label" for="flexCheckDefault">
                            Новый автомобиль
                        </label>
                    </div>


                    {{--  --}}
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="client_fio" id="client_fio" type="text" class="form-control mb-1"
                            dusk="fio" placeholder="ФИО клиента" style="display: none">
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="client_number" id="client_number" type="text" class="form-control mb-1"
                            dusk="number" placeholder="Номер телефона" style="display: none">
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="client_mark" id="client_mark" type="text" class="form-control mb-1"
                            dusk="mark" placeholder="Марка автомобиля" style="display: none">
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="client_model" id="client_model" type="text" class="form-control mb-1"
                        dusk="model" placeholder="Модель автомобиля" style="display: none">
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <input name="client_gos_number" id="client_gos_number" type="text" class="form-control  mb-1"
                        dusk="gos_number"placeholder="Гос. номер автомобиля" style="display: none">
                    </div>
                    {{--  --}}
                    <div class="col d-flex align-items-center justify-content-center mt-2">
                        <textarea name="client_reson" id="client_reson" type="text" class="form-control  mb-1" required
                        dusk="resone" placeholder="Причина посещения автосервиса"></textarea>
                    </div>
                    {{--  --}}
                    <div class="col d-flex align-items-center justify-content-center mt-3">
                        <a id="back" href="/" class="btn btn-primary me-3 mb-1" id="">Назад</a>
                        <button  dusk="add" value="add" id="save" class="btn btn-primary  mb-1"
                            id="">Создать</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

<script>
    let formSend = () => document.getElementById("formAction").submit();

    function setFind() {
        const clientFind = document.getElementById('client_find');
        const id = document.getElementById('id');
        window.location = "/record_appointment?id=" + id.value + "&fio=" + clientFind.value;
    }

    function showAddCar() {
        const cbNewCar = document.getElementById('cbNewCar');
        const addMark = document.getElementById('add_mark');
        const addModel = document.getElementById('add_model');
        const addGosNumder = document.getElementById('add_gos_number');
        const selectCar = document.getElementById('select_car');

        const test = document.getElementById('new')

        if (!cbNewCar.checked) {
            selectCar.style.display = "block";
            addMark.style.display = "none";
            addMark.required = false;
            addModel.style.display = "none";
            addModel.required = false;
            addGosNumder.style.display = "none";
            addGosNumder.required = false;
            test.value = 'add';
        } else {
            selectCar.style.display = "none";
            addMark.style.display = "block";
            addMark.required = true;
            addModel.style.display = "block";
            addModel.required = true;
            addGosNumder.style.display = "block";
            addGosNumder.required = true;
            test.value = 'add_car';
        }
    }

    function showFindClient(whoClick) {
        const findClientBt = document.getElementById('client_find_menu_bt')
        const addClientBt = document.getElementById('client_add_menu_bt')

        const select = document.getElementById('select_client');

        const selectCar = document.getElementById('select_car');
        const text = document.getElementById('label_client');
        const input = document.getElementById('client_find');
        const btfind = document.getElementById('client_find_bt');
        const cbNewCar = document.getElementById('cbNewCar');
        const addMark = document.getElementById('add_mark');
        const addModel = document.getElementById('add_model');
        const addGosNumder = document.getElementById('add_gos_number');
        const new_car_label = document.getElementById('new_car_label');
        const new_car_div = document.getElementById('new_car_div');

        const inputFio = document.getElementById('client_fio');
        const inputNumber = document.getElementById('client_number');
        const inputMark = document.getElementById('client_mark');
        const inputModel = document.getElementById('client_model');
        const inputGosNubber = document.getElementById('client_gos_number');

        const test = document.getElementById('new')

        if (whoClick == "find") {
            findClientBt.classList.add("active")
            addClientBt.classList.remove("active")

            text.style.display = "block";
            input.style.display = "block";
            select.style.display = "block";
            select.required = true;
            btfind.style.display = "block";
            selectCar.style.display = "block";
            selectCar.required = true;
            cbNewCar.style.display = "block";
            addMark.style.display = "none";
            addMark.required = false;
            addModel.style.display = "none";
            addModel.required = false;
            addGosNumder.style.display = "none";
            addGosNumder.required = false;
            new_car_label.style.display = "block";
            new_car_div.style.display = "block";

            inputFio.style.display = "none";
            inputFio.required = false;
            inputNumber.style.display = "none";
            inputNumber.required = false;
            inputMark.style.display = "none";
            inputMark.required = false;
            inputModel.style.display = "none";
            inputModel.required = false;
            inputGosNubber.style.display = "none";
            inputGosNubber.required = false;

            test.value = 'add';

        } else {
            addClientBt.classList.add("active")
            findClientBt.classList.remove("active")

            text.style.display = "none";
            input.style.display = "none";
            select.style.display = "none";
            select.required = false;
            btfind.style.display = "none";
            selectCar.style.display = "none";
            selectCar.required = false;
            cbNewCar.style.display = "none";
            cbNewCar.checked = false;
            addMark.style.display = "none";
            addMark.required = false;
            addModel.style.display = "none";
            addMark.required = false;
            addGosNumder.style.display = "none";
            addGosNumder.required = false;
            new_car_label.style.display = "none";
            new_car_div.style.display = "none";

            inputFio.style.display = "block";
            inputFio.required = true;
            inputNumber.style.display = "block";
            inputNumber.required = true;
            inputMark.style.display = "block";
            inputMark.required = true;
            inputModel.style.display = "block";
            inputModel.required = true;
            inputGosNubber.style.display = "block";
            inputGosNubber.required = true;

            test.value = 'new';
        }
    }

    function setSelect() {
        var idPosition = 0;
        //var MOselect = document.getElementById("MOselect");
        var select_client = document.getElementById("select_client");
        // var OOselect = document.getElementById("job");
        var select_car = document.getElementById("select_car");

        // OOselect.options.length = 0;
        select_car.options.length = 0;

        // var str = MOselect.options[MOselect.selectedIndex].text;
        var id = select_client.options[select_client.selectedIndex].value;
        // console.log(str);


        // var MOname ;
        // var OOname ;
        var cars = @json($cars, JSON_UNESCAPED_UNICODE);

        // for (i = 0; i < clients.length; i++) {
        //     if (clients[i]['id'] == id) {
        //         idPosition = i;
        //         break;
        //     }
        // }
        // // var id = clients[idPosition][id];
        for (i = 0; i < cars.length; i++) {
            if (cars[i]['id_client'] == id) {
                var option = document.createElement('option');
                option.value = cars[i]['id'];
                option.innerHTML = cars[i]['mark'] + " " + cars[i]['model'];
                select_car.appendChild(option);
            }
        }
    }
</script>
