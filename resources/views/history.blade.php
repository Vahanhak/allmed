@if(!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] != 'doctor')
    <script>window.location = "/";</script>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AlmaMed</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body class="d-body">
@include('metrika')
<div class="container">
    <div class="d-top">AlmaMed</div>
    <div class="d-exit"><a href="/logout">Выйти</a></div>
    <h2>Статистика</h2>
    <div class="picker">
        <div id="picker-month">
            <a></a>
            <div class="input-append date" id="month_datepicker" data-date="{{ date("m-Y") }}" data-date-format="mm-yyyy">
                <input  type="text" readonly="readonly" name="date" value="{{ $month }}">
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
            <a></a>
        </div>
    </div>
    <div class="statistics">
        <div>
            <div>Всего заявок</div>
            <div id="data_count"></div>
        </div>
        <div>
            <div>Оформлено отмен</div>
            <div id="canceled"></div>
        </div>
        <div>
            <div>Некорректный адрес</div>
            <div id="invalid_address"></div>
        </div>
        <div>
            <div>Уже госпитализирован</div>
            <div id="already_hospitalized"></div>
        </div>
        <div>
            <div>Отказ от осмотра</div>
            <div id="refusal_inspect"></div>
        </div>
        <div>
            <div>Осмотр другой МО или МБ</div>
            <div id="another_mo_mb"></div>
        </div>
        <div class="total">
            <div>Обработанных заявок</div>
            <div id="processed"></div>
        </div>
    </div>
    <h2>История заявок</h2>
    <div class="picker">
        <div id="picker-day">
            <a></a>
            <div class="input-append date" id="day_datepicker" data-date="{{ date("d-m-Y") }}" data-date-format="dd-mm-yyyy">
                <input  type="text" readonly="readonly" name="date" value="{{ $day }}">
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
            <a></a>
        </div>
    </div>
    <p>&nbsp;</p>
    <div class="applications-found">
        Заявок найдено: <span class="app_count"></span>
    </div>
</div>
@csrf
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ru.min.js"></script>
<script>
    $(function() {
        const months = [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
             'Октябрь',
             'Ноябрь',
             'Декабрь'
        ];
        const days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
        const sday = {2:'Понедельник', 3:'Вторник', 4:'Среда', 5:'Четверг', 6:'Пятница', 7:'Суббота', 1:'Воскресенье'};
        const _token = $('input[name="_token"]').val();
        $("#month_datepicker").datepicker({
            format: 'MM/yyyy',
            startView: "months",
            minViewMode: "months",
            language: "ru",
        });
        $("#day_datepicker").datepicker({
            format: 'DD, dd/mm/yyyy',
            language: "ru",
        });
        function loadMonth(_token, month) {
            $.ajax('/history/month', {
                type: 'POST',
                data: {_token, month},
                success: function (data) {
                    $('#data_count').text(data.data_count);
                    $('#already_hospitalized').text(data.already_hospitalized);
                    $('#another_mo_mb').text(data.another_mo_mb);
                    $('#canceled').text(data.canceled);
                    $('#invalid_address').text(data.invalid_address);
                    $('#processed').text(data.processed);
                    $('#refusal_inspect').text(data.refusal_inspect);
                }
            });
        }
        function loadDay(_token, day) {
            $.ajax('/history/day', {
                type: 'POST',
                data: {_token, day},
                success: function (data) {
                    $('.history-item').remove();
                    $('.app_count').text(data.app_count);
                    let html = '';
                    if (data.app) {
                        for(let a of data.app) {
                            if(a.route_sheet_status == 'Отменена') {
                                html += '<a class="history-item">';
                                html += '<p>Статус: <strong class="red">Отменена</strong></p>';
                                html += '<p>Причина отмены: <strong>Уже госпитализирован</strong></p>';
                                html += '<p>Пациент: <strong>' + a.fio + '</strong></p>';
                                html += '<p>Адрес: <strong>' + a.address + '</strong></p>';
                                html += '</a>';
                            }
                            else { // if (a.route_sheet_status == 'Выполнена')
                                html += '<a class="history-item">';
                                html += '<p>Предварительный диагноз: <strong>' + a.predvoritelniy_diagnoz + '</strong></p>';
                                html += '<p>Пациент: <strong>' + a.fio + '</strong></p>';
                                html += '<p>Адрес: <strong>' + a.address + '</strong></p>';
                                html += '</a>';
                            }
                        }
                    }
                    $('.applications-found').after(html);
                }
            });
        }
        $('#month_datepicker').on('changeDate', function(){
            $(this).datepicker('hide');
            loadMonth(_token, $('#month_datepicker > input').val());
        });
        $('#day_datepicker').on('changeDate', function(){
            $(this).datepicker('hide');
            loadDay(_token, $('#day_datepicker > input').val());
        });
        let month = 'now';
        let day = 'now';
        loadMonth(_token, month);
        loadDay(_token, day);
        $(document).on('click', '#picker-month > a:nth-child(1)', function () {
            let temp = $('#month_datepicker').datepicker('getDate');
            let m = temp.getMonth() - 1;
            let y = temp.getFullYear();
            if(m < 0) {
                m = 11;
                y = y - 1;
            }
            loadMonth(_token, months[m]+'/'+y);
            $('#month_datepicker').datepicker('update', months[m]+'/'+y);
            $('#month_datepicker > input').val(months[m]+'/'+y);
        });
        $(document).on('click', '#picker-month > a:nth-child(3)', function () {
            let temp = $('#month_datepicker').datepicker('getDate');
            let m = temp.getMonth() + 1;
            let y = temp.getFullYear();
            if(m >= 12) {
                m = 0;
                y = y + 1;
            }
            loadMonth(_token, months[m]+'/'+y);
            $('#month_datepicker').datepicker('update', months[m]+'/'+y);
            $('#month_datepicker > input').val(months[m]+'/'+y);
        });
        $(document).on('click', '#picker-day > a:nth-child(1)', function () {
            let temp = $('#day_datepicker').datepicker('getDate');
            let w = temp.getDay();
            let d = temp.getDate() - 1;
            let m = temp.getMonth() + 1;
            let y = temp.getFullYear();
            if(w < 1) {
                w = 7;
            }
            if((m === 1 || m === 2 || m === 4 || m === 6 || m === 8 || m === 11) && d <= 0) {
                d = 31;
                m = m - 1;
            }
            else if((m === 5 || m === 7 || m === 10 || m === 12) && d <= 0) {
                d = 30;
                m = m - 1;
            }
            else if(m === 3 && d <= 0) {
                d = 28;
                m = m - 1;
            }
            if(m <= 0) {
                m = 11;
                y = y - 1;
            }
            loadDay(_token, sday[w] + ', ' + d + '/' + m + '/' + y);
            $('#day_datepicker').datepicker('update', sday[w] + ', ' + d + '/' + m + '/' + y);
            $('#day_datepicker > input').val(sday[w] + ', ' + d + '/' + m + '/' + y);
        });
        $(document).on('click', '#picker-day > a:nth-child(3)', function () {
            let temp = $('#day_datepicker').datepicker('getDate');
            let w = temp.getDay();
            let d = temp.getDate() + 1;
            let m = temp.getMonth() + 1;
            let y = temp.getFullYear();
            if(w > 7) {
                w = 1;
            }
            if((m === 1 || m === 3 || m === 5 || m === 7 || m === 8 || m === 10 || m === 12) && d > 31) {
                d = 1;
                m = m + 1;
            }
            else if((m === 4 || m === 6 || m === 9 || m === 11) && d > 30) {
                d = 1;
                m = m + 1;
            }
            else if(m === 2 && d > 28 && y !== 2024) {
                d = 1;
                m = m + 1;
            }
            else if(m === 2 && d > 29) {
                d = 1;
                m = m + 1;
            }
            if(m > 12) {
                m = 1;
                y = y + 1;
            }
            loadDay(_token, days[w] + ', ' + d + '/' + m + '/' + y);
            $('#day_datepicker').datepicker('update', days[w] + ', ' + d + '/' + m + '/' + y);
            $('#day_datepicker > input').val(days[w] + ', ' + d + '/' + m + '/' + y);
        });
    });
</script>
</body>
</html>
