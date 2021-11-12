@if(!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] != 'doctor')
    <script>window.location = "/";</script>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AlmaMed</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body class="d-body">
@include('metrika')
<div class="container">
    <div class="d-top">AlmaMed</div>
    <div class="d-exit"><a href="/logout">Выйти</a></div>
    <h2>Новая заявка</h2>
    @if (session('status'))
        <h6 class="alert-success">{{ session('status') }}</h6>
    @endif
    <a href="/doctor" class="add-new-record">+ Добавить новую запись</a>
    <h2>Маршрутный лист</h2>
    @if($data)
        @csrf
        <div class="applications-found">
            Заявок найдено: <span>{{ count($data) }}</span>
        </div>
        @foreach($data as $item)
            <a class="route_sheet_list"
                @if($item['srochno'] == 1)
                    style="background-color:#FD4A4A"
                @elseif($item['srochno'] == 2)
                    style="background-color:#FF7A00;background-image: url('/img/fire.png');"
                @endif
                data-id="{{ $item['id'] }}">
                <p>Тип:
                    <strong>{{ $item['srochno'] == 1 ? '' : '' }}
                        @if($item['srochno'] == 1)
                            Срочно
                        @elseif($item['srochno'] == 2)
                            Очаг
                        @else
                            Не срочно
                        @endif
                    </strong>
                </p>
                <p>Адрес: <strong>{{ $item['address'] }}</strong></p>
                <p>Пациент: <strong>{{ $item['fio'] }}</strong></p>
                <p>Дата и время: <strong>{{ date("d.m.Y H:i:s", strtotime($item['created_at'])) }}</strong></p>
            </a>
        @endforeach
    @endif
    <h2>История</h2>
    <a href="/history" class="open-history">Открыть историю</a>
</div>
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function () {
    $(document).on('click', '.route_sheet_list', function () {
        const id = $(this).attr('data-id');
        let html = '<div class="custom-modal">';
        html += '<div class="cm-title">Выберите действие <a>x</a></div>';
        html += '<div class="cm-body" data-id="'+id+'">';
        html += '<h3>Оформить отмену</h3>';
        html += '<p>';
        html += 'Заявка будет отменена, по одной из следующих причин:';
        html += '</p>';
        html += '<a>Некорректный адрес</a>';
        html += '<a>Уже госпитализирован</a>';
        html += '<a>Отказ от осмотра</a>';
        html += '<a>Осмотр другой МО или МБ</a>';
        html += '</div>';
        html += '<a class="cm-footer" href="/doctor/'+id+'">';
        html += '<h3>Заполнить заявку</h3>';
        html += '<p>Откроется стандартная форма для создания заявки, с данными от оператора</p>';
        html += '</a>';
        html += '</div>';
        $('body')
            .append('<div class="bgr"></div>')
            .append(html);
    });
    $(document).on('click', '.cm-title > a, .bgr, .cm-body.first-step > a:nth-child(3)', function () {
        $('.bgr, .custom-modal').remove();
    });
    $(document).on('click', '.cm-body:not(.first-step) > a', function () {
        const txt = $(this).text();
        const id = $(this).closest('div').attr('data-id');
        let html = '<div class="custom-modal" style="top: 200px;">';
        html += '<div class="cm-title">Вы уверены? <a>x</a></div>';
        html += '<div class="cm-body first-step" data-txt="'+txt+'" data-id="'+id+'">';
        html += '<h3>Оформить отмену заявки?</h3>';
        html += '<p>';
        html += '&nbsp;';
        html += '</p>';
        html += '<a>Нет</a>';
        html += '<a>Отменить Заявку</a>';
        html += '</div>';
        html += '</div>';
        $('.custom-modal').remove();
        $('body')
            .append(html);
    });
    $(document).on('click', '.first-step > a:last-child', function () {
        const txt = $(this).closest('div').attr('data-txt');
        const id = $(this).closest('div').attr('data-id');
        const _token = $('input[name="_token"]').val();
        $.ajax('/ajax/application_status', {
            type: 'POST',
            data: {id, txt, _token},
            success: function (data) {
                if(data === 'ok') {
                    let num = $('.applications-found span').text();
                    if(num > 0) {
                        num = num - 1;
                        $('.applications-found span').text(num);
                    }
                    $('.bgr, .custom-modal').remove();
                    $('.route_sheet_list[data-id="'+id+'"]').remove();
                }
            }
        });
    });
});
</script>
</body>
</html>
