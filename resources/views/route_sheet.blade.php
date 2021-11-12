@if(!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] != 'operator')
    <script>window.location = "/";</script>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AlmaMed</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body class="o-body">
@include('metrika')
<div class="container">
    <div class="o-top">AlmaMed</div>
    <div class="o-exit">
        <a href="/operator" class="fl">Заявки</a>
        <a href="/operator/route/sheet" class="fl">Маршрутные листы</a>
        <a href="/logout">Выйти</a>
    </div>
    <h2>Маршрутные листы</h2>
    <div class="table">
        <form action="/operator/route/sheet" method="get" name="f_form">
            <table>
                <tr>
                    <td>
                        <label for="vrach">Врач</label>
                        <select name="vrach" id="vrach">
                            <option value=""></option>
                            @foreach($data['doctors'] as $doctor_id=>$doctor)
                                <option value="{{ $doctor_id }}"
                                @if(old('vrach') == $doctor_id)
                                    selected
                                @endif>{{ $doctor }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label for="fio_pacient">ФИО пациента</label>
                        <input type="text" name="fio_pacient" id="fio_pacient" value="{{ old('fio_pacient') }}">
                    </td>
                    <td>
                        <label for="iin_pacient">ИИН пациента</label>
                        <input type="text" name="iin_pacient" id="iin_pacient" value="{{ old('iin_pacient') }}">
                    </td>
                    <td>
                        <label for="phone_pacient">Телефон пациента</label>
                        <input style="width: calc(100% - 20px);" type="text" name="phone_pacient" id="phone_pacient" value="{{ old('phone_pacient') }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="filter_date">Дата: с - до</label>
                        <input type="text" name="filter_date" id="filter_date" value="{{ old('filter_date') }}">
                    </td>
                    <td>
                        <label for="status_zayavki">Статус заявки маршрутного листа</label>
                        <select name="status_zayavki" id="status_zayavki" style="width: calc(100% - 20px);">
                            <option value="">Все</option>
                            <option value="Новая"
                                    @if(old('status_zayavki') == 'Новая')
                                    selected
                                @endif>Новая</option>
                            <option value="Выполнена"
                                    @if(old('status_zayavki') == 'Выполнена')
                                    selected
                                @endif>Выполнена</option>
                            <option value="Отменена"
                                    @if(old('status_zayavki') == 'Отменена')
                                    selected
                                @endif>Отменена</option>
                        </select>
                    </td>
                    <td>
                        <label for="srochno_id">Тип</label>
                        <select name="srochno" id="srochno_id" style="width: calc(100% - 20px);">
                            <option value="">Все</option>
                            <option value="1000"
                                    @if(old('srochno') == '1000')
                                    selected
                                @endif>Не срочно</option>
                            <option value="1"
                                    @if(old('srochno') == '1')
                                    selected
                                @endif>Срочно</option>
                            <option value="2"
                                    @if(old('srochno') == '2')
                                    selected
                                @endif>Очаг</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="action">
                        <button type="button" onclick="javascript: window.location='/operator/route/sheet/reset';" class="btn reset">Очистить</button>
                        <button class="btn">Поиск</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    @if (session('status'))
        <h6 class="alert-success">{{ session('status') }}</h6>
    @endif
    <div class="list">
        <div class="data-info">
            @if($data['applications']->total() === 0)
                Нет данных
            @else
                Показаны <strong>{{ $data['applications']->firstItem() }}-{{ $data['applications']->lastItem() }}</strong> из
                <strong>{{ $data['applications']->total() }}</strong> записи
            @endif
            <a href="/operator/add/route/sheet" class="route_sheet_plus" title=""><img src="/img/plus.png" alt=""></a>
        </div>

        <table>
            <tr>
                <th>#</th>
                <th>ФИО врача</th>
                <th>ИИН</th>
                <th>ФИО пациента</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Дата и время заявки</th>
                <th>Статус маршрутного листа</th>
                <th>Действия</th>
            </tr>
            @php
                $i = $data['applications']->firstItem();
            @endphp
            @foreach($data['applications'] as $application)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $data['doctors'][$application['doctor_id']] }}</td>
                    <td>{{ $application['inn'] }}</td>
                    <td>{{ $application['fio'] }}</td>
                    <td>{{ $application['phone'] }}</td>
                    <td>{{ $application['address'] }}</td>
                    <td>{{ $application['created_at'] }}</td>
                    <td>{{ $application['route_sheet_status'] ?? 'Новая' }}</td>
                    <td align="center"><a href="/operator/edit/route/sheet/{{ $application['id'] }}"><img src="/img/edit_icon.png" alt=""></a></td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </table>
    </div>
    <div class="pagination">
        @if($data['applications']->currentPage() > 1)
            <a href="?page={{ $data['applications']->currentPage() - 1 }}{{ $data['search'] }}">&laquo;</a>
        @endif
        @for($i=1; $i <= $data['pages']; $i++)
            <a href="?page={{ $i }}{{ $data['search'] }}"
               @if($data['applications']->currentPage() === $i)
               class="active"
               @endif>{{ $i }}</a>
        @endfor
        @if($data['applications']->currentPage() < $data['pages'])
            <a href="?page={{ $data['applications']->currentPage() + 1 }}{{ $data['search'] }}">&raquo;</a>
        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function() {
    const fDate = $('input[name="filter_date"]');
    fDate.daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Очистить',
            applyLabel: 'Применить'
        }
    });
    fDate.on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
    fDate.on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
});
</script>
</body>
</html>
