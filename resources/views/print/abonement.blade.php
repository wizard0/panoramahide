@php
    $halfyear = date('m') < 6 ? '1' : '2';
    $year = date('Y');
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
<body>
<script>window.print();</script>
<div style="font-family:  DejaVu Sans, sans-serif; width: 480px;">

    <p><b>{!! $title !!}</b></p>
    <p style="color:red">Стоимость подписки на журнал уточняйте в отделениях связи по каталогу {!! $catalog !!}</p>
    <div style="padding:30px 43px 40px 15px; border:1px dashed #000; float:left; margin-right:15px"><table border="0" cellpadding="0" cellspacing="0" width="488">
            <tbody><tr>
                <td style="border-right:2px solid #000000; border-bottom:2px solid #000000;" valign="top" width="203">
                    ф. СП-1
                </td>
                <td style="border-bottom:2px solid #000000;">

                    <table width="100%">
                        <tbody><tr>
                            <td align="center" width="240">
                                <b>АБОНЕМЕНТ</b>
                            </td>
                            <td align="center">
                                на журнал
                            </td>
                            <td align="right">
                                <table width="150">
                                    <tbody>
                                    <tr>
                                        <td style="border:1px solid #000000; width: 146px;" align="center">
                                            <b>{{ $abonementID }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">(индекс издания)</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>

                        </tr>
                        </tbody></table>


                    <table style=" border-collapse:collapse;" border="1" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="left">
                                <b>{{ $journalName }}</b><br style="clear:both">(наименование издания)
                            </td>
                            <td style="border:1px solid #000000" align="left" width="30">
                                Количество комплектов:
                            </td>
                            <td style="border:1px solid #000000" align="left" width="50">
                                &nbsp;{{ $count }}                </td>
                        </tr>
                        </tbody></table>
                    <br>
                    Срок подписки: 12 мес., {{ $halfyear }} полугодие {{ $year }} г.         <table style=" border-collapse:collapse;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="center">
                                1
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                2
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                3
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                4
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                5
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                6
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                7
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                8
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                9
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                10
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                11
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                12
                            </td>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 12; $i++)
                                @if ($abonementStartMonth >= $i)
                                    <td style="border:1px solid #000000" align="center">

                                        &nbsp;
                                    </td>
                                @else
                                    <td style="border:1px solid #000000" align="center">

                                        *&nbsp;
                                    </td>
                                @endif
                            @endfor
                        </tr>
                        </tbody></table>
                    <br>


                    <table style=" border-collapse:collapse;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="left" width="15">Куда:</td>
                            <td style="border:1px solid #000000" align="left" width="30">{{ $userIndex }}</td>
                            <td style="border:1px solid #000000" align="left">&nbsp;{{ $userAddr }}</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000" align="left" width="40">&nbsp;</td>
                            <td style="border:1px solid #000000" align="center" width="50">(индекс)</td>
                            <td style="border:1px solid #000000" align="center">(адрес)</td>
                        </tr>
                        </tbody></table>

                    <table style=" border-collapse:collapse;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="left" width="40">Кому:</td>
                            <td style="border:1px solid #000000" align="left">&nbsp;{{ $userName }}</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000" align="left">&nbsp;</td>
                            <td style="border:1px solid #000000" align="left">(фамилия, инициалы)</td>
                        </tr>
                        </tbody></table>

                </td>
            </tr>
            <tr>
                <td colspan="2" height="18"><div style="border:1px dashed #666; margin:5px"></div></td>
            </tr>

            <tr>
                <td style="border-right:2px solid #000000; border-top:2px solid #000000">&nbsp;</td>
                <td style="border-top:2px solid #000000"><table width="100%">
                        <tbody><tr>
                            <td align="center" width="240">
                                <b>ДОСТАВОЧНАЯ КАРТОЧКА</b>
                            </td>
                            <td align="center">
                                на журнал
                            </td>
                            <td align="right">
                                <table width="150"><tbody>
                                    <tr>
                                        <td style="border:1px solid #000000; width: 146px" align="center">
                                            <b>{{ $abonementID }}</b>
                                        </td>
                                    </tr>
                                    <tr><td align="center">(индекс издания)</td></tr></tbody></table>
                            </td>

                        </tr>
                        </tbody></table>

                    <table style=" border-collapse:collapse;" width="120">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="center" width="40">&nbsp;</td>
                            <td style="border:1px solid #000000" align="center" width="40">&nbsp;</td>
                            <td style="border:1px solid #000000" align="center" width="40">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000" align="center">ПВ</td>
                            <td style="border:1px solid #000000" align="center">место</td>
                            <td style="border:1px solid #000000" align="center">литер</td>
                        </tr>
                        </tbody></table>
                    <table style=" border-collapse:collapse;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="center">
                                <b>{{ $journalName }}</b><br style="clear:both">(наименование издания)
                            </td>

                        </tr>
                        </tbody></table>

                    <table style=" border-collapse:collapse;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td rowspan="2" style="border:1px solid #000000" align="center" width="20">
                                Стои-<br>мость
                            </td>

                            <td style="border:1px solid #000000" align="center">
                                подписки
                            </td>
                            <td style="border:1px solid #000000" align="right">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;руб.&nbsp;&nbsp;&nbsp;коп.
                            </td>
                            <td rowspan="2" style="border:1px solid #000000" align="center">
                                Кол-во<br>комплектов
                            </td>
                            <td rowspan="2" style="border:1px solid #000000" align="left" width="40">
                                &nbsp;{{ $count }}                </td>

                        </tr>

                        <tr>

                            <td style="border:1px solid #000000" align="center">
                                пере-<br>адресовки
                            </td>
                            <td style="border:1px solid #000000" align="right">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;руб.&nbsp;&nbsp;&nbsp;коп.
                            </td>

                        </tr>

                        </tbody></table>
                    Срок подписки:  12 мес., {{ $halfyear }} полугодие {{ $year }} г.         <table style=" border-collapse:collapse;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="center">
                                1
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                2
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                3
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                4
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                5
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                6
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                7
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                8
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                9
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                10
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                11
                            </td>
                            <td style="border:1px solid #000000" align="center">
                                12
                            </td>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 12; $i++)
                                @if ($abonementStartMonth >= $i)
                                    <td style="border:1px solid #000000" align="center">

                                        &nbsp;
                                    </td>
                                @else
                                    <td style="border:1px solid #000000" align="center">

                                        *&nbsp;
                                    </td>
                                @endif
                            @endfor
                        </tr>
                        </tbody></table></td>
            </tr>
            <tr>
                <td colspan="2"><table style=" border-collapse:collapse;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="left" width="50">Куда:</td>
                            <td style="border:1px solid #000000" align="left" width="123">{{ $userIndex }}</td>
                            <td style="border:1px solid #000000" align="left" width="312">&nbsp;{{ $userAddr }}</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000" align="left">&nbsp;</td>
                            <td style="border:1px solid #000000" align="left">(индекс)</td>
                            <td style="border:1px solid #000000" align="left">(адрес)</td>
                        </tr>
                        </tbody></table>

                    <table style=" border-collapse:collapse;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td style="border:1px solid #000000" align="left" width="50">Кому:</td>
                            <td style="border:1px solid #000000" align="left">&nbsp;{{ $userName }}</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000" align="left">&nbsp;</td>
                            <td style="border:1px solid #000000" align="left">(фамилия, инициалы)</td>
                        </tr>
                        </tbody></table></td>
            </tr>


            </tbody></table></div>
</div>

</body>
</html>
