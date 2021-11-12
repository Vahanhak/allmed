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
    <form action="/doctor{{ $id ? '/'.$id : '' }}" method="post" id="form_id">
        @csrf
        <div class="d-div">
            <label for="fio">ФИО <span>*</span></label>
            <input type="text" name="fio" id="fio" value="{{ $app['fio'] ?? '' }}" autofocus>
        </div>
        <div class="d-div">
            <label for="inn">ИНН <span>*</span></label>
            <input type="text" name="inn" id="inn" value="{{ $app['inn'] ?? '' }}">
        </div>
        <div class="d-div">
            <label for="address">Адрес проживания <span>*</span></label>
            <input type="text" name="address" id="address" value="{{ $app['address'] ?? '' }}">
        </div>
        <div class="d-div">
            <label for="phone">Телефон <span>*</span></label>
            <input type="text" name="phone" id="phone" value="{{ $app['phone'] ?? '' }}">
        </div>
        <div class="d-div">
            <label for="additional_phone">Дополнительный телефон</label>
            <input type="text" name="additional_phone" id="additional_phone" value="{{ $app['additional_phone'] ?? '' }}">
        </div>
        <div class="d-div">
            <label for="mesto_raboty">Место работы</label>
            <input type="text" name="mesto_raboty" id="mesto_raboty" value="{{ $app['mesto_raboty'] ?? '' }}">
        </div>
        <div class="d-div">
            <label for="doljnost">Должность</label>
            <input type="text" name="doljnost" id="doljnost" value="{{ $app['doljnost'] ?? '' }}">
        </div>
        <div class="d-i-title">
            Больничный лист
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="bolnichniy_list" value="Нужен"
                   id="bolnichniy_list_1"{{ $app['bolnichniy_list']=='Нужен' ? ' checked' : '' }}>
            <label for="bolnichniy_list_1">Нужен</label>
            <input type="radio" class="stv-radio-button" name="bolnichniy_list" value="Не нужен"
                   id="bolnichniy_list_2"{{ $app['bolnichniy_list']=='Не нужен' ? ' checked' : ($app['bolnichniy_list']==null ? ' checked' : '') }}>
            <label for="bolnichniy_list_2">Не нужен</label>
        </div>
        <div class="d-i-title">
            Осмотр
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="osmotr" value="Первичный"
                   id="pervichniy"{{ $app['osmotr']=='Первичный' ? ' checked' : ($app['osmotr']==null ? ' checked' : '') }}>
            <label for="pervichniy">Первичный</label>
            <input type="radio" class="stv-radio-button" name="osmotr" value="Повторный"
                   id="povtorniy"{{ $app['osmotr']=='Повторный' ? ' checked' : '' }}>
            <label for="povtorniy">Повторный</label>
        </div>
        <div class="d-i-title">
            ПЦР
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="pcr" value="Отрицательный"
                   id="otricatelniy"{{ $app['pcr']=='Отрицательный' ? ' checked' : '' }}>
            <label for="otricatelniy" class="w25">Отрицательный</label>
            <input type="radio" class="stv-radio-button" name="pcr" value="Положительный"
                   id="polojitelniy"{{ $app['pcr']=='Положительный' ? ' checked' : ($app['pcr']==null ? ' checked' : '') }}>
            <label for="polojitelniy" class="w25">Положительный</label>
            <input type="radio" class="stv-radio-button" name="pcr" value="Ожидание результата"
                   id="ojidanie_rezultata"{{ $app['pcr']=='Ожидание результата' ? ' checked' : '' }}>
            <label for="ojidanie_rezultata" class="w25">Ожидание результата</label>
            <input type="radio" class="stv-radio-button" name="pcr" value="Нет"
                   id="net"{{ $app['pcr']=='Нет' ? ' checked' : '' }}>
            <label for="net" class="w25">Нет</label>
        </div>
        <div class="d-div" id="date_pcr_div">
            <label for="date_pcr">Дата ПЦР</label>
            <input type="date" name="date_pcr" id="date_pcr" value="{{ $app['date_pcr'] ?? '' }}">
        </div>
        <div class="d-i-title">
            KT
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="kt" value="Да"
                   id="kt_da"{{ $app['kt']=='Да' ? ' checked' : '' }}>
            <label for="kt_da">Да</label>
            <input type="radio" class="stv-radio-button" name="kt" value="Нет"
                   id="kt_net"{{ $app['kt']=='Нет' ? ' checked' : ($app['kt']==null ? ' checked' : '') }}>
            <label for="kt_net">Нет</label>
        </div>
        <div class="d-div" id="date_kt_div" style="display: none;">
            <label for="date_kt">Дата КТ</label>
            <input type="date" name="date_kt" id="date_kt" value="{{ $app['date_kt'] ?? '' }}">
        </div>
        <div class="d-i-title kt_result_div" style="display: none;">
            Результат КТ
        </div>
        <div class="stv-radio-buttons-wrapper kt_result_div" style="display: none;">
            <input type="radio" class="stv-radio-button" name="kt_result" value="Без патологии"
                   id="kt_bez_patologii"{{ $app['kt_result']=='Без патологии' ? ' checked' : '' }}>
            <label class="w33" for="kt_bez_patologii">Без&nbsp;патологии</label>
            <input type="radio" class="stv-radio-button" name="kt_result" value="Поражение"
                   id="kt_parajenie"{{ $app['kt_result']=='Поражение' ? ' checked' : '' }}>
            <label class="w33" for="kt_parajenie">Поражение</label>
            <input type="radio" class="stv-radio-button" name="kt_result" value="Другое"
                   id="kt_drugoe"{{ $app['kt_result']=='Другое' ? ' checked' : '' }}>
            <label class="w33" for="kt_drugoe">Другое</label>
        </div>
        <div class="d-div" id="d_percent_porojeniya">
            <label for="percent_porojeniya">% поражения</label>
            <input type="text" name="percent_porojeniya" id="percent_porojeniya" value="{{ $app['percent_porojeniya'] ?? '' }}">
        </div>
        <div class="d-div" id="kt_d_drugoe">
            <label for="kt_input_drugoe">Другое</label>
            <input type="text" name="kt_input_drugoe" id="kt_input_drugoe" value="{{ $app['kt_input_drugoe'] ?? '' }}">
        </div>
        <div class="d-i-title">
            Д-учет
        </div>
        <div class="stv-radio-buttons-wrapper">
            @if(!empty($app['duchet']))
                @php
                    $arr = [];
                @endphp
                @if(!empty($app['duchet']))
                    @php
                        $arr = json_decode($app['duchet']);
                    @endphp
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="Нет" id="dujet_1"
                           @if(!empty($arr) && in_array('Нет', $arr))
                           checked
                        @endif>
                    <label for="dujet_1" class="w9">Нет</label>
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="ССЗ (АГ,ИБС,ХСН)" id="dujet_2"
                           @if(!empty($arr) && in_array('ССЗ (АГ,ИБС,ХСН)', $arr))
                           checked
                        @endif>
                    <label for="dujet_2" class="w9">ССЗ (АГ,ИБС,ХСН)</label>
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="СД 1 типа" id="dujet_3"
                           @if(!empty($arr) && in_array('СД 1 типа', $arr))
                           checked
                        @endif>
                    <label for="dujet_3" class="w9">СД 1 типа</label>
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="СД 2 типа" id="dujet_4"
                           @if(!empty($arr) && in_array('СД 2 типа', $arr))
                           checked
                        @endif>
                    <label for="dujet_4" class="w9">СД 2 типа</label>
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="Онко" id="dujet_5"
                           @if(!empty($arr) && in_array('Онко', $arr))
                           checked
                        @endif>
                    <label for="dujet_5" class="w9">Онко</label>
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="ХОБЛ/Астма" id="dujet_6"
                           @if(!empty($arr) && in_array('ХОБЛ/Астма', $arr))
                           checked
                        @endif>
                    <label for="dujet_6" class="w9">ХОБЛ/Астма</label>
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="РА" id="dujet_7"
                           @if(!empty($arr) && in_array('РА', $arr))
                           checked
                        @endif>
                    <label for="dujet_7" class="w9">РА</label>
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="Беременность" id="dujet_8"
                           @if(!empty($arr) && in_array('Беременность', $arr))
                           checked
                        @endif>
                    <label for="dujet_8" class="w9">Беременность</label>
                    <input type="checkbox" class="stv-radio-button" name="duchet[]" value="Другое" id="dujet_9"
                           @if(!empty($arr) && in_array('Другое', $arr))
                           checked
                        @endif>
                    <label for="dujet_9" class="w9">Другое</label>
                @endif
            @else
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="Нет" id="dujet_1">
                <label for="dujet_1" class="w9">Нет</label>
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="ССЗ (АГ,ИБС,ХСН)" id="dujet_2">
                <label for="dujet_2" class="w9">ССЗ (АГ,ИБС,ХСН)</label>
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="СД 1 типа" id="dujet_3">
                <label for="dujet_3" class="w9">СД 1 типа</label>
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="СД 2 типа" id="dujet_4">
                <label for="dujet_4" class="w9">СД 2 типа</label>
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="Онко" id="dujet_5">
                <label for="dujet_5" class="w9">Онко</label>
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="ХОБЛ/Астма" id="dujet_6">
                <label for="dujet_6" class="w9">ХОБЛ/Астма</label>
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="РА" id="dujet_7">
                <label for="dujet_7" class="w9">РА</label>
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="Беременность" id="dujet_8">
                <label for="dujet_8" class="w9">Беременность</label>
                <input type="checkbox" class="stv-radio-button" name="duchet[]" value="Другое" id="dujet_9">
                <label for="dujet_9" class="w9">Другое</label>
            @endif
        </div>
        <div class="d-div" id="ber_ned_div">
            <label for="ber_ned">Срок беременности (недель)</label>
            <input type="text" name="ber_ned" id="ber_ned" value="{{ $app['ber_ned'] ?? '' }}">
        </div>
        <div class="d-div">
            <label for="epid_okrujenie">Эпид. окружение</label>
            <textarea name="epid_okrujenie" id="epid_okrujenie">{{ $app['epid_okrujenie'] ?? '' }}</textarea>
        </div>
        <div class="d-i-title">
            Прием постоянных медикаментов
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="ppm" value="Да"
                   id="ppm_1"{{ $app['ppm']=='Да' ? ' checked' : '' }}>
            <label for="ppm_1">Да</label>
            <input type="radio" class="stv-radio-button" name="ppm" value="Нет"
                   id="ppm_2"{{ $app['ppm']=='Нет' ? ' checked' : ($app['ppm']==null ? ' checked' : '') }}>
            <label for="ppm_2">Нет</label>
        </div>
        <div class="d-div nazvanie_ls_div" style="display: none;">
            <label for="nazvanie_ls">Названия ЛС</label>
            <textarea name="nazvanie_ls" id="nazvanie_ls">{{ $app['nazvanie_ls'] ?? '' }}</textarea>
        </div>
        <div class="d-i-title">
            Вакцинация
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="vakcinaciya" value="Нет"
                   id="vakcinaciya_1"{{ $app['vakcinaciya']=='Нет' ? ' checked' : ($app['vakcinaciya']==null ? ' checked' : '') }}>
            <label for="vakcinaciya_1">Нет</label>
            <input type="radio" class="stv-radio-button" name="vakcinaciya" value="Да"
                   id="vakcinaciya_2"{{ $app['vakcinaciya']=='Да' ? ' checked' : '' }}>
            <label for="vakcinaciya_2">Да</label>
        </div>
        <div class="d-div vakcinaciya_da">
            <label for="date_1_etap">Дата 1 этапа</label>
            <input type="date" name="date_1_etap" id="date_1_etap" value="{{ $app['date_1_etap'] ?? '' }}">
        </div>
        <div class="d-div vakcinaciya_da">
            <label for="date_2_etap">Дата 2 этапа</label>
            <input type="date" name="date_2_etap" id="date_2_etap" value="{{ $app['date_2_etap'] ?? '' }}">
        </div>
        <div class="d-i-title vakcinaciya_da">
            Препарат
        </div>
        <div class="stv-radio-buttons-wrapper vakcinaciya_da">
            <input type="radio" class="stv-radio-button" name="preparat" value="Спутник V"
                   id="sputnik_v"{{ $app['preparat']=='Спутник V' ? ' checked' : '' }}>
            <label class="w25" for="sputnik_v">Спутник V</label>
            <input type="radio" class="stv-radio-button" name="preparat" value="Coronavac"
                   id="coronavac"{{ $app['preparat']=='Coronavac' ? ' checked' : '' }}>
            <label class="w25" for="coronavac">Coronavac</label>
            <input type="radio" class="stv-radio-button" name="preparat" value="Qazcovid"
                   id="qazcovid"{{ $app['preparat']=='Qazcovid' ? ' checked' : '' }}>
            <label class="w2x3 br-lb" for="qazcovid">Qazcovid</label>
            <input type="radio" class="stv-radio-button" name="preparat" value="Hayat"
                   id="hayat"{{ $app['preparat']=='Hayat' ? ' checked' : '' }}>
            <label class="w2x3" for="hayat">Hayat</label>
            <input type="radio" class="stv-radio-button" name="preparat" value="Vero Cell"
                   id="vero_cell"{{ $app['preparat']=='Vero Cell' ? ' checked' : '' }}>
            <label class="w2x3 br-rb" for="vero_cell">Vero Cell</label>
        </div>
        <div style="clear: both;margin-bottom: 10px;"></div>
        <div class="d-div">
            <label for="saturaciya">Сатурация</label>
            <input type="text" name="saturaciya" id="saturaciya" min="0" max="100" value="{{ $app['saturaciya'] ?? '' }}">
        </div>
        <div class="d-div">
            <label for="temperatura">Температура</label>
            <input type="text" name="temperatura" id="temperatura" min="25" max="42" value="{{ $app['temperatura'] ?? '' }}">
        </div>
        <div class="d-i-title">
            Слабость
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="slabost" value="Да"
                   id="slabost_1"{{ $app['slabost']=='Да' ? ' checked' : ($app['slabost']==null ? ' checked' : '') }}>
            <label for="slabost_1">Да</label>
            <input type="radio" class="stv-radio-button" name="slabost" value="Нет"
                   id="slabost_2"{{ $app['slabost']=='Нет' ? ' checked' : '' }}>
            <label for="slabost_2">Нет</label>
        </div>
        <div class="d-i-title">
            Рвота, тошнота
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="rvota_toshnota" value="Да"
                   id="rvota_toshnota_1"{{ $app['rvota_toshnota']=='Да' ? ' checked' : '' }}>
            <label for="rvota_toshnota_1">Да</label>
            <input type="radio" class="stv-radio-button" name="rvota_toshnota" value="Нет"
                   id="rvota_toshnota_2"{{ $app['rvota_toshnota']=='Нет' ? ' checked' : ($app['rvota_toshnota']==null ? ' checked' : '') }}>
            <label for="rvota_toshnota_2">Нет</label>
        </div>
        <div class="d-i-title">
            Диарея
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="diareya" value="Да"
                   id="diareya_1"{{ $app['diareya']=='Да' ? ' checked' : '' }}>
            <label for="diareya_1">Да</label>
            <input type="radio" class="stv-radio-button" name="diareya" value="Нет"
                   id="diareya_2"{{ $app['diareya']=='Нет' ? ' checked' : ($app['diareya']==null ? ' checked' : '') }}>
            <label for="diareya_2">Нет</label>
        </div>
        <div class="d-i-title">
            Потеря обоняния
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="poterya_obonaniya" value="Да"
                   id="poterya_obonaniya_1"{{ $app['poterya_obonaniya']=='Да' ? ' checked' : ($app['poterya_obonaniya']==null ? ' checked' : '') }}>
            <label for="poterya_obonaniya_1">Да</label>
            <input type="radio" class="stv-radio-button" name="poterya_obonaniya" value="Нет"
                   id="poterya_obonaniya_2"{{ $app['poterya_obonaniya']=='Нет' ? ' checked' : '' }}>
            <label for="poterya_obonaniya_2">Нет</label>
        </div>
        <div class="d-i-title">
            Потеря вкуса
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="poterya_vkusa" value="Да"
                   id="poterya_vkusa_1"{{ $app['poterya_vkusa']=='Да' ? ' checked' : ($app['poterya_vkusa']==null ? ' checked' : '') }}>
            <label for="poterya_vkusa_1">Да</label>
            <input type="radio" class="stv-radio-button" name="poterya_vkusa" value="Нет"
                   id="poterya_vkusa_2"{{ $app['poterya_vkusa']=='Нет' ? ' checked' : '' }}>
            <label for="poterya_vkusa_2">Нет</label>
        </div>
        <div class="d-i-title">
            Кашель
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="kashel" value="Сухой"
                   id="kashel_1"{{ $app['kashel']=='Сухой' ? ' checked' : '' }}>
            <label class="w33" for="kashel_1">Сухой</label>
            <input type="radio" class="stv-radio-button" name="kashel" value="Влажный"
                   id="kashel_2"{{ $app['kashel']=='Влажный' ? ' checked' : '' }}>
            <label class="w33" for="kashel_2">Влажный</label>
            <input type="radio" class="stv-radio-button" name="kashel" value="Нет"
                   id="kashel_3"{{ $app['kashel']=='Нет' ? ' checked' : ($app['kashel']==null ? ' checked' : '') }}>
            <label class="w33" for="kashel_3">Нет</label>
        </div>
        <div class="d-i-title">
            Затрудненное дыхание
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="zatrudnenoe_dixanie" value="Да"
                   id="zatrudnenoe_dixanie_1"{{ $app['zatrudnenoe_dixanie']=='Да' ? ' checked' : '' }}>
            <label for="zatrudnenoe_dixanie_1">Да</label>
            <input type="radio" class="stv-radio-button" name="zatrudnenoe_dixanie" value="Нет"
                   id="zatrudnenoe_dixanie_2"{{ $app['zatrudnenoe_dixanie']=='Нет' ? ' checked' : ($app['zatrudnenoe_dixanie']==null ? ' checked' : '') }}>
            <label for="zatrudnenoe_dixanie_2">Нет</label>
        </div>
        <div class="d-i-title">
            Одышка
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="odishka" value="Да"
                   id="odishka_1"{{ $app['odishka']=='Да' ? ' checked' : '' }}>
            <label for="odishka_1">Да</label>
            <input type="radio" class="stv-radio-button" name="odishka" value="Нет"
                   id="odishka_2"{{ $app['odishka']=='Нет' ? ' checked' : ($app['odishka']==null ? ' checked' : '') }}>
            <label for="odishka_2">Нет</label>
        </div>
        <div class="d-i-title">
            Назначить анализы
        </div>
        <div class="stv-radio-buttons-wrapper">
            @if(!empty($app['naznachit_analiz']))
                @php
                    $arr2 = [];
                @endphp
                @if(!empty($app['naznachit_analiz']))
                    @php
                        $arr2 = json_decode($app['naznachit_analiz']);
                    @endphp
                @endif
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="ОАК" id="na_1"
                       @if(!empty($arr2) && in_array('ОАК', $arr2))
                       checked
                    @endif>
                <label for="na_1" class="w6">ОАК</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Д-Димер" id="na_2"
                       @if(!empty($arr2) && in_array('Д-Димер', $arr2))
                       checked
                    @endif>
                <label for="na_2" class="w6">Д-Димер</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Каогулограмма" id="na_3"
                       @if(!empty($arr2) && in_array('Каогулограмма', $arr2))
                       checked
                    @endif>
                <label for="na_3" class="w6">Каогулограмма</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Биохимия" id="na_4"
                       @if(!empty($arr2) && in_array('Биохимия', $arr2))
                       checked
                    @endif>
                <label for="na_4" class="w6">Биохимия</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Гликированный гемоглобин" id="na_5"
                       @if(!empty($arr2) && in_array('Гликированный гемоглобин', $arr2))
                       checked
                    @endif>
                <label for="na_5" class="w6">Гликированный гемоглобин</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Бакпосев мокроты с АБ-чув." id="na_6"
                       @if(!empty($arr2) && in_array('Бакпосев мокроты с АБ-чув.', $arr2))
                       checked
                    @endif>
                <label for="na_6" class="w6">Бакпосев мокроты с АБ-чув.</label>
            @else
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="ОАК" id="na_1">
                <label for="na_1" class="w6">ОАК</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Д-Димер" id="na_2">
                <label for="na_2" class="w6">Д-Димер</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Каогулограмма" id="na_3">
                <label for="na_3" class="w6">Каогулограмма</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Биохимия" id="na_4">
                <label for="na_4" class="w6">Биохимия</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Гликированный гемоглобин" id="na_5">
                <label for="na_5" class="w6">Гликированный гемоглобин</label>
                <input type="checkbox" class="stv-radio-button" name="naznachit_analiz[]" value="Бакпосев мокроты с АБ-чув." id="na_6">
                <label for="na_6" class="w6">Бакпосев мокроты с АБ-чув.</label>
            @endif
        </div>
        <div class="d-i-title">
            Назначить КТ
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="naznachit_kt" value="Да"
                   id="naznachit_kt_1"{{ $app['naznachit_kt']=='Да' ? ' checked' : '' }}>
            <label for="naznachit_kt_1">Да</label>
            <input type="radio" class="stv-radio-button" name="naznachit_kt" value="Нет"
                   id="naznachit_kt_2"{{ $app['naznachit_kt']=='Нет' ? ' checked' : '' }}>
            <label for="naznachit_kt_2">Нет</label>
        </div>
        <div class="d-div">
            <label for="dopolnitelno">Дополнительно</label>
            <textarea name="dopolnitelno" id="dopolnitelno">{{ $app['dopolnitelno'] ?? '' }}</textarea>
        </div>
        <div class="d-div">
            <label for="naznacheni_ls">Назначены ЛС <span>*</span></label>
            <textarea name="naznacheni_ls" id="naznacheni_ls">{{ $app['naznacheni_ls'] ?? '' }}</textarea>
        </div>
        <div class="d-i-title">
            Предварительный диагноз
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="predvoritelniy_diagnoz" value="U07.1"
                   id="predvoritelniy_diagnoz_1"
                {{ $app['predvoritelniy_diagnoz']=='U07.1' ? ' checked' : ($app['predvoritelniy_diagnoz']==null ? ' checked' : '') }}>
            <label class="w6" for="predvoritelniy_diagnoz_1">U07.1</label>
            <input type="radio" class="stv-radio-button" name="predvoritelniy_diagnoz" value="J06.9"
                   id="predvoritelniy_diagnoz_2"{{ $app['predvoritelniy_diagnoz']=='J06.9' ? ' checked' : '' }}>
            <label class="w6" for="predvoritelniy_diagnoz_2">J06.9</label>
            <input type="radio" class="stv-radio-button" name="predvoritelniy_diagnoz" value="J18.0"
                   id="predvoritelniy_diagnoz_3"{{ $app['predvoritelniy_diagnoz']=='J18.0' ? ' checked' : '' }}>
            <label class="w6" for="predvoritelniy_diagnoz_3">J18.0</label>
            <input type="radio" class="stv-radio-button" name="predvoritelniy_diagnoz" value="J02.9"
                   id="predvoritelniy_diagnoz_4"{{ $app['predvoritelniy_diagnoz']=='J02.9' ? ' checked' : '' }}>
            <label class="w6" for="predvoritelniy_diagnoz_4">J02.9</label>
            <input type="radio" class="stv-radio-button" name="predvoritelniy_diagnoz" value="J03.9"
                   id="predvoritelniy_diagnoz_5"{{ $app['predvoritelniy_diagnoz']=='J03.9' ? ' checked' : '' }}>
            <label class="w6" for="predvoritelniy_diagnoz_5">J03.9</label>
            <input type="radio" class="stv-radio-button" name="predvoritelniy_diagnoz" value="J04.9"
                   id="predvoritelniy_diagnoz_6"{{ $app['predvoritelniy_diagnoz']=='J04.9' ? ' checked' : '' }}>
            <label class="w6" for="predvoritelniy_diagnoz_6">J04.9</label>
        </div>
        <div class="d-i-title">
            Степень
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="stepen" value="Бессимптомный"
                   id="stepen_1"{{ $app['stepen']=='Бессимптомный' ? ' checked' : '' }}>
            <label for="stepen_1" class="w25">Бессимптомный</label>
            <input type="radio" class="stv-radio-button" name="stepen" value="Легкая"
                   id="stepen_2"{{ $app['stepen']=='Легкая' ? ' checked' : ($app['stepen']==null ? ' checked' : '') }}>
            <label for="stepen_2" class="w25">Легкая</label>
            <input type="radio" class="stv-radio-button" name="stepen" value="Среднетяжелая"
                   id="stepen_3"{{ $app['stepen']=='Среднетяжелая' ? ' checked' : '' }}>
            <label for="stepen_3" class="w25">Среднетяжелая</label>
            <input type="radio" class="stv-radio-button" name="stepen" value="Тяжелая"
                   id="stepen_4"{{ $app['stepen']=='Тяжелая' ? ' checked' : '' }}>
            <label for="stepen_4" class="w25">Тяжелая</label>
        </div>
        <div class="d-i-title">
            Исход
        </div>
        <div class="stv-radio-buttons-wrapper">
            <input type="radio" class="stv-radio-button" name="isxod" value="Амбулаторное лечение"
                   id="isxod_1"{{ $app['isxod']=='Амбулаторное лечение' ? ' checked' : ($app['isxod']==null ? ' checked' : '') }}>
            <label for="isxod_1">Амбулаторное лечение</label>
            <input type="radio" class="stv-radio-button" name="isxod" value="Госпитализация"
                   id="isxod_2"{{ $app['isxod']=='Госпитализация' ? ' checked' : '' }}>
            <label for="isxod_2">Госпитализация</label>
        </div>
        <div class="big-split"></div>
        <button type="submit" name="submit" id="d-submit">Сохранить и отправить</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="/js/mask.min.js"></script>
<script>
    $(function () {
        $("#phone").mask("7(799) 999 9999");
        $("#additional_phone").mask("7(799) 999 9999");
        $("#inn").mask("999999999999");
        const spp = $("#saturaciya, #percent_porojeniya");
        spp.mask('##0%', {reverse: true});
        spp.attr('maxlength', '4');
        $("#temperatura").mask("99.9");
        $(this).on('click', '#kt_bez_patologii', function () {
            $('#d_percent_porojeniya, #kt_d_drugoe').hide();
            $('body .d-div.dblck').removeClass('dblck');
        }).on('click', '#kt_parajenie', function () {
            $('#d_percent_porojeniya').show();
            $('#kt_d_drugoe').hide();
            $('body .d-div.dblck').removeClass('dblck');
        }).on('click', '#kt_drugoe', function () {
            $('#d_percent_porojeniya').hide();
            $('#kt_d_drugoe').show();
            $('body .d-div.dblck').removeClass('dblck');
        }).on('click', '#d-submit:not(.disable_btn)', function (e) {
            if ($('#fio').val() === '') {
                e.preventDefault();
                $('#fio').addClass('d-error').focus();
            } else if ($('#inn').val() === '' || $('#inn').val().length !== 12) {
                e.preventDefault();
                $('#inn').addClass('d-error').focus();
            } else if ($('#address').val() === '') {
                e.preventDefault();
                $('#address').addClass('d-error').focus();
            } else if ($('#phone').val() === '') {
                e.preventDefault();
                $('#phone').addClass('d-error').focus();
            } else if ($('#naznacheni_ls').val() === '') {
                e.preventDefault();
                $('#naznacheni_ls').addClass('d-error').focus();
            } else {
                $(this).after('<div>Отправка данных формы...</div>');
                $(this).remove();
                $('#form_id').submit();
            }
        }).on('click', 'label', function () {
            const pos = $(window).scrollTop();
            $("html, body").animate({scrollTop: pos});
        }).on('click', '#kt_net', function () {
            $('#date_kt_div, .kt_result_div').hide();
            $('#date_kt').val('');
            $("input[name='kt_result']").each(function () {
                this.checked = false;
            });
        }).on('click', '#kt_da', function () {
            $('#date_kt_div, .kt_result_div').show();
        }).on('click', '#net', function () {
            $('#date_pcr_div').hide();
        }).on('click', '#vakcinaciya_1', function () {
            $('.vakcinaciya_da').hide();
            $('#date_1_etap, #date_2_etap').val('');
            $('.vakcinaciya_da input[type="radio"]').prop('checked', false);
        }).on('click', '#vakcinaciya_2', function () {
            $('.vakcinaciya_da').show();
        }).on('click', '#otricatelniy, #polojitelniy, #ojidanie_rezultata', function () {
            $('#date_pcr_div').show();
        }).on('click', '[name="duchet[]"]', function () {
            if ($('#dujet_8:checkbox:checked').length > 0) {
                $('#ber_ned_div').show();
            } else {
                $('#ber_ned_div').hide();
                $('#ber_ned').val('');
            }
        }).on('click', '#ppm_1', function () {
            $('.nazvanie_ls_div').show();
        }).on('click', '#ppm_2', function () {
            $('.nazvanie_ls_div').hide();
            $('#nazvanie_ls').val('');
        });
    });
</script>
</body>
</html>
