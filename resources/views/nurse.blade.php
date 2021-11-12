@if(!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] != 'nurse')
    <script>window.location = "/";</script>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AlmaMed</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body class="o-body">
@include('metrika')
<div class="container">
    <div class="o-top">AlmaMed</div>
    <div class="o-exit"><a href="/logout">Выйти</a></div>
    <h2>Заявки на обследования и анализы</h2>
    <div class="table">
        <form action="/nurse" method="get" name="f_form">
            <table>
                <tr>
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
                        <input type="text" name="phone_pacient" id="phone_pacient" value="{{ old('phone_pacient') }}">
                    </td>
                    <td>
                        <label for="status_zayavki">Статус заявки</label>
                        <select name="status_zayavki" id="status_zayavki">
                            <option value="">Все</option>
                            <option value="Новая"
                                    @if(old('status_zayavki') == 'Новая')
                                    selected
                                @endif>Новая
                            </option>
                            <option value="В работе"
                                    @if(old('status_zayavki') == 'В работе')
                                    selected
                                @endif>В работе
                            </option>
                            <option value="Выполнена"
                                    @if(old('status_zayavki') == 'Выполнена')
                                    selected
                                @endif>Выполнена
                            </option>
                            <option value="Отклонена"
                                    @if(old('status_zayavki') == 'Отклонена')
                                    selected
                                @endif>Отклонена
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="filter_date">Дата: с - до</label>
                        <input type="text" name="filter_date" id="filter_date" value="{{ old('filter_date') }}">
                    </td>
                    <td colspan="3"></td>
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
                        <button type="button" onclick="javascript: window.location='/nurse/reset';" class="btn reset">Очистить</button>
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
            @if($data['total'] === 0)
                Нет данных
            @else
                Показаны <strong><span class="offset">1</span>-<span class="limit">10</span></strong> из <strong class="total">{{ $data['total'] }}</strong> записи
            @endif
        </div>

        <table>
            <tr>
                <th>#</th>
                <th>ИИН</th>
                <th>ФИО пациента</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Дата и время заявки</th>
                <th>Обследование / анализ</th>
                <th>Статус заявки</th>
            </tr>
            @foreach($data['applications'] as $key=>$application)
                <tr data-txt="{{ $application['name'] }}" data-id="{{ $application['id'] }}" {{ ($key > 9) ? ' style=display:none' : '' }} data-page="{{ ($key + 1) }}">
                    <td>{{ ($key + 1) }}<input type="hidden" name="results" value="{{ $application['results'] }}"></td>
                    <td>{{ $application['inn'] }}</td>
                    <td>{{ $application['fio'] }}</td>
                    <td>{{ $application['phone'] }}</td>
                    <td>{{ $application['address'] }}</td>
                    <td>{{ $application['created_at'] }}</td>
                    <td><a data-id="{{ $application['id'] }}" class="btn-href">{{ $application['name'] }}</a></td>
                    <td>
                        @if($application['status'] == 'Выполнена')
                            Выполнена
                        @elseif($application['status'] == 'Отклонена')
                            Отклонена
                        @elseif($application['status'] == 'В работе')
                            В работе
                        @else
                            Новая
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="pagination">
        @if($data['total'])
            <a class="pagination_first_step">&laquo;</a>
            @for($i=1; $i <= ceil($data['total']/10); $i++)
                <a class="pagination-js{{ ($i === 1) ? ' active' : '' }}" data-id="{{ $i }}">{{ $i }}</a>
            @endfor
            @if($data['total'] > 10)
                <a class="pagination_last_step">&raquo;</a>
            @endif
        @endif
    </div>
</div>
@csrf
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(function () {
        @if($data['total'] && $data['total'] < 10)
        $('.limit').text({{ $data['total'] }});
        @endif
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

        function page(id) {
            $('.pagination-js').removeClass('active');
            $('.pagination-js[data-id="' + id + '"]').addClass('active');
            $('.list table tr').each(function () {
                if ($(this).attr('data-page') > ((id - 1) * 10) && $(this).attr('data-page') <= ((id - 1) * 10 + 10)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('.list table tr:first-child').show();
            if (id > 1) {
                $('.pagination_first_step').addClass('show');
            } else {
                $('.pagination_first_step').removeClass('show');
            }
            if ($('.pagination-js').length <= id) {
                $('.pagination_last_step').hide();
            } else {
                $('.pagination_last_step').show();
            }
            let active = $('.pagination-js.active').attr('data-id');
            let total = $('.total').text();
            if (active == 1) {
                $('.offset').text(active);
                $('.limit').text(active * 10);
            } else if (active > 1) {
                $('.offset').text((active - 1) *10 + 1);
                if(active * 10 > total) {
                    $('.limit').text(total);
                }
                else {
                    $('.limit').text(active * 10);
                }
            }
        }

        $(document).on('click', '.pagination-js', function () {
            page($(this).attr('data-id'), $(this));
        });
        $(document).on('click', '.pagination_first_step', function () {
            page($('.pagination-js.active').attr('data-id') - 1);
        });
        $(document).on('click', '.pagination_last_step', function () {
            page(+$('.pagination-js.active').attr('data-id') + 1);
        });
        $(document).on('click', '.btn-href', function () {
            const id = $(this).attr('data-id');
            const txt = $(this).text();
            let res = $(this).closest('tr').find('input[name="results"]').val();
            let status = $(this).closest('tr').find('td:nth-child(8)').text().trim();
            $.ajax('/ajax/application_management', {
                type: 'GET',
                data: {id, txt},
                success: function (data) {
                    let html = '<div class="custom-modal" data-id="' + id + '" data-txt="' + txt + '">';
                    html += '<div class="cm-title"><strong>Заявки на обследование/анализы</strong> <a>x</a></div>';
                    html += '<div class="cm-body" style="background-color: white;">';
                    html += '<div>Пациент: <strong>' + data.fio + '</strong></div>';
                    html += '<div>Обследование/анализы: <strong>' + txt + '</strong></div>';
                    html += '<label for="rezult-area">';
                    html += 'Результат:';
                    html += '</label>';
                    html += '<textarea name="rezult" id="rezult-area" cols="30" rows="10">' + res + '</textarea>';
                    html += '</div>';
                    html += '<div class="cm-footer" style="background-color: white;">';
                    html += '<label for="status_analiz">Статус:</label>';
                    html += '<select name="status_analiz" id="status_analiz">';
                    html += '<option value="Новая"';
                    if (status === 'Новая') {
                        html += ' selected';
                    }
                    html += '>Новая</option>';
                    html += '<option value="В работе"';
                    if (status === 'В работе') {
                        html += ' selected';
                    }
                    html += '>В работе</option>';
                    html += '<option value="Выполнена"';
                    if (status === 'Выполнена') {
                        html += ' selected';
                    }
                    html += '>Выполнена</option>';
                    html += '<option value="Отклонена"';
                    if (status === 'Отклонена') {
                        html += ' selected';
                    }
                    html += '>Отклонена</option>';
                    html += '</select>';
                    html += '<div class="right">';
                    html += '<button class="btn-analiz" data-id="' + id + '" data-txt="' + txt + '">Сохранить</button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    $('body')
                        .append('<div class="bgr"></div>')
                        .append(html);
                }
            });
        });
        $(document).on('click', '.cm-title > a, .bgr', function () {
            $('.bgr, .custom-modal').remove();
        });
        $(document).on('click', '.btn-analiz', function () {
            const id = $(this).attr('data-id');
            const txt = $(this).attr('data-txt');
            const _token = $('input[name="_token"]').val();
            const result = $('#rezult-area').val();
            const status = $('#status_analiz').val();
            if (id && txt) {
                $.ajax('/ajax/application_statuses', {
                    type: 'POST',
                    data: {id, txt, _token, result, status},
                    success: function (data) {
                        if (data === 'ok') {
                            $('.list table tr[data-id="' + id + '"][data-txt="' + txt + '"] input[name="results"]').val(result);
                            $('.list table tr[data-id="' + id + '"][data-txt="' + txt + '"] td:nth-child(8)').text(status);
                            $('.bgr, .custom-modal').remove();
                        }
                    }
                });
            }
        });
    });
</script>
</body>
</html>
