<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <TITLE>Счет</TITLE>


    <STYLE>

        .print_button {
            background-color: #ffeedd;
            position: sticky;
            top: 10px;
        }
    </STYLE>
    <style type="text/css" media="print">
        .print_button {display: none; }
    </style>

</HEAD>


<BODY TEXT="#000000">
<button class = "print_button" onclick="window.print();">Печать</button>
<TABLE FRAME=VOID CELLSPACING=0 COLS=37 RULES=NONE BORDER=0 style="width:100%;">
    <COLGROUP><COL WIDTH=20><COL WIDTH=11><COL WIDTH=9><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=16><COL WIDTH=15><COL WIDTH=16><COL WIDTH=16><COL WIDTH=20><COL WIDTH=2><COL WIDTH=19><COL WIDTH=20><COL WIDTH=14><COL WIDTH=7><COL WIDTH=20><COL WIDTH=14><COL WIDTH=7><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=16><COL WIDTH=4><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=20><COL WIDTH=11></COLGROUP>
    <TBODY>
        <!--<TR>
            <TD COLSPAN=37 ROWSPAN=3 WIDTH=623 HEIGHT=44 ALIGN=CENTER VALIGN=MIDDLE>Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате <BR> обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту<BR> прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.

            </TD>
            </TR>
        <TR>
            </TR>
        <TR>
            </TR>-->
        <TR>
            <TD HEIGHT=14 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=19 ROWSPAN=2 HEIGHT=29 ALIGN=LEFT VALIGN=TOP><FONT SIZE=2>{{ $data->supplier_bank }} {{ $data->bank_city }}</FONT></TD>
            <TD STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=5 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=2>БИК</FONT></TD>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=13 ALIGN=LEFT VALIGN=MIDDLE SDVAL="44525593" SDNUM="1049;0;000000000"><FONT SIZE=2>{{ $data->BIC }}</FONT></TD>
            </TR>
        <TR>
            <TD STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=5 ROWSPAN=2 ALIGN=LEFT VALIGN=TOP><FONT SIZE=2>Сч. №</FONT></TD>
            <TD STYLE="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=13 ROWSPAN=2 ALIGN=LEFT VALIGN=TOP><FONT SIZE=2>{{ $data->correspondent_account }}</FONT></TD>
            </TR>
        <TR>
            <TD STYLE="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=19 HEIGHT=14 ALIGN=LEFT>Банк получателя</TD>
            </TR>
        <TR>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000" COLSPAN=3 HEIGHT=16 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=2>ИНН</FONT></TD>
            <TD STYLE="border-top: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=7 ALIGN=LEFT VALIGN=MIDDLE SDVAL="{{ $data->INN }}" SDNUM="1049;0;0"><FONT SIZE=2>
                        {{ $data->INN }}                      </FONT></TD>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000" COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=2>КПП  </FONT></TD>
            <TD STYLE="border-top: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=7 ALIGN=LEFT VALIGN=MIDDLE SDVAL="{{ $data->KPP }}" SDNUM="1049;0;0"><FONT SIZE=2>
                        {{ $data->KPP }}                       </FONT></TD>
            <TD STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=5 ROWSPAN=4 ALIGN=LEFT VALIGN=TOP><FONT SIZE=2>Сч. №</FONT></TD>
            <TD STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" COLSPAN=13 ROWSPAN=4 ALIGN=LEFT VALIGN=TOP><FONT SIZE=2>{{ $data->supplier_current_account }}</FONT></TD>
            </TR>
        <TR>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000" COLSPAN=19 ROWSPAN=2 HEIGHT=28 ALIGN=LEFT VALIGN=TOP><FONT SIZE=2>
            {{ $data->supplier_name }}</FONT></TD>
            </TR>
        <TR>
            </TR>
        <TR>
            <TD STYLE="border-bottom: 1px solid #000000; border-left: 1px solid #000000" COLSPAN=19 HEIGHT=14 ALIGN=LEFT VALIGN=MIDDLE>Получатель</TD>
            </TR>
        <TR>
            <TD HEIGHT=14 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD COLSPAN=37 ROWSPAN=2 HEIGHT=28 ALIGN=LEFT VALIGN=MIDDLE><B><FONT SIZE=4>
                        <nobr>Счет на оплату №{{ $order->id }} от {{ $order->date }}</nobr>
            </FONT></B></TD>
            </TR>
        <TR>
            </TR>
        <TR>
            <TD STYLE="border-bottom: 3px solid #000000" COLSPAN=37 HEIGHT=9 ALIGN=LEFT><BR></TD>
            </TR>
        <TR>
            <TD HEIGHT=9 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD COLSPAN=5 HEIGHT=50 ALIGN=LEFT VALIGN=TOP><FONT SIZE=2>Поставщик:</FONT></TD>
            <TD COLSPAN=32 ALIGN=LEFT VALIGN=TOP><B><FONT SIZE=2>
            {{ $data->supplier_name }}, ИНН {{ $data->INN }}, КПП {{ $data->KPP }} ,{{ $data->supplier_address }} ,Тел.: {{ $data->phone }}
            <!--{{ $data->supplier_name }}, ИНН {{ $data->INN }}, КПП {{ $data->KPP }}, {{ $data->supplier_address }}, тел.: {{ $data->phone }}-->
            </FONT></B></TD>
            </TR>
        <TR>
            <TD HEIGHT=9 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD COLSPAN=5 HEIGHT=34 ALIGN=LEFT VALIGN=TOP><FONT SIZE=2>Покупатель:</FONT></TD>
            <TD COLSPAN=32 ALIGN=LEFT VALIGN=TOP><B><FONT SIZE=2>
            {{ $user->org_name }}, @if($user->INN) ИНН {{ $user->INN }},@endif @if($user->KPP) КПП {{ $user->KPP }},@endif {{ $user->l_phone }}, {{ $user->getFullName()}}
            </FONT></B></TD>
            </TR>
        <TR>
            <TD HEIGHT=9 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD STYLE="border-top: 3px solid #000000; border-left: 3px solid #000000" COLSPAN=2 HEIGHT=16 ALIGN=CENTER VALIGN=MIDDLE><B><FONT SIZE=2>№</FONT></B></TD>
            <TD STYLE="border-top: 3px solid #000000; border-left: 1px solid #000000" COLSPAN=18 ALIGN=CENTER VALIGN=MIDDLE>
                <B><FONT SIZE=2>Товары (работы, услуги)</FONT></B></TD>
            <TD STYLE="border-top: 3px solid #000000; border-left: 1px solid #000000" COLSPAN=3 ALIGN=CENTER VALIGN=MIDDLE><B><FONT SIZE=2>Кол-во</FONT></B></TD>
            <TD STYLE="border-top: 3px solid #000000; border-left: 1px solid #000000" COLSPAN=3 ALIGN=CENTER VALIGN=MIDDLE><B><FONT SIZE=2>Ед.</FONT></B></TD>
            <TD STYLE="border-top: 3px solid #000000; border-left: 1px solid #000000" COLSPAN=5 ALIGN=CENTER VALIGN=MIDDLE><B><FONT SIZE=2>Цена</FONT></B></TD>
            <TD STYLE="border-top: 3px solid #000000; border-left: 1px solid #000000; border-right: 3px solid #000000" COLSPAN=6 ALIGN=CENTER VALIGN=MIDDLE>
                <B><FONT SIZE=2>Сумма</FONT></B>
            </TD>
        </TR>
        @foreach($items as $item)
        <TR>
            <TD STYLE="border-top: 1px solid #000000; border-left: 3px solid #000000" COLSPAN=2 HEIGHT=44 ALIGN=CENTER VALIGN=TOP>
                {{ $loop->index + 1}}
            </TD>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000" COLSPAN=18 ALIGN=LEFT VALIGN=TOP>
                {{ $item->title }}</br>
                {{ $item->typeVers }}
            </TD>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000" COLSPAN=3 ALIGN=RIGHT VALIGN=TOP>
                {{ $item->qty }}
            </TD>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000" COLSPAN=3 ALIGN=RIGHT VALIGN=TOP>
                шт
            </TD>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000" COLSPAN=5 ALIGN=RIGHT VALIGN=TOP>
                {{ $item->price }}
            </TD>
            <TD STYLE="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 3px solid #000000" COLSPAN=6 ALIGN=RIGHT VALIGN=TOP>
                {{ $item->price * $item->qty }}
            </TD>
        </TR>
        @endforeach



        <TR>
            <TD STYLE="border-top: 3px solid #000000" HEIGHT=9 ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-top: 3px solid #000000" ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD HEIGHT=16 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2>Итого:</FONT></B></TD>
            <TD COLSPAN=6 ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2>{{ $order->totalPrice['sum'] }}</FONT></B></TD>
            </TR>
        <TR>
            <TD HEIGHT=16 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <!--<TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>-->
            <TD COLSPAN=8 ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2>В том числе НДС(10%):</FONT></B></TD>
            <TD COLSPAN=6 ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2>{{ $order->totalPrice['tax'] }}
            </FONT></B></TD>
            </TR>
        <TR>
            <TD HEIGHT=16 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <!--<TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>
            <TD ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2><BR></FONT></B></TD>-->
            <TD COLSPAN=8 ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2>Всего к оплате:</FONT></B></TD>
            <TD COLSPAN=6 ALIGN=RIGHT VALIGN=TOP><B><FONT SIZE=2>{{ $order->totalPrice['total'] }}   </FONT></B></TD>
            </TR>
        <TR>
            <TD COLSPAN=37 HEIGHT=16 ALIGN=LEFT><FONT SIZE=2>
            Всего наименований {{ count((array)$items) }}, на сумму {{ $order->totalPrice['total'] }} руб.            </FONT></TD>
            </TR>
        <TR>
            <TD COLSPAN=36 HEIGHT=18 ALIGN=LEFT VALIGN=TOP><B><FONT SIZE=2>
            {{ $order->totalPrice['string'] }}</FONT></B></TD>
            <TD ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD STYLE="border-bottom: 3px solid #000000" HEIGHT=9 ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 3px solid #000000" ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD HEIGHT=14 ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
        </TR>
        <TR>
            <TD HEIGHT=16 ALIGN=LEFT style="position: relative;">
                <img src="{{ Storage::url($data->stamp) }}" style="position: absolute; top:-50px;left:10px;" alt="" width="142" height="143" />
                <B><FONT SIZE=2>Руководитель</FONT></B>
            </TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT>
                <br>
            </TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT>
                <img src="{{ Storage::url($data->CEO_signature) }}" border="0" alt="" width="92" height="30" />
            </TD>
            <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR>
            </TD>
            <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
            <TD STYLE="border-bottom: 1px solid #000000" COLSPAN=9 ALIGN=RIGHT>{{ $data->manager_full_name }}</TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><B><FONT SIZE=2>Бухгалтер</FONT></B></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT><BR></TD>
            <TD ALIGN=LEFT>
                <br>
            </TD>
            <TD ALIGN=LEFT>
                <br>
            </TD>
            <TD ALIGN=LEFT>
                <img src="{{ Storage::url($data->chief_accountant_sign) }}" border="0" alt="" width="85" height="20" />
            </TD>
            <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR>
                        </TD>
            <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>

            <TD STYLE="border-bottom: 1px solid #000000" COLSPAN=8 ALIGN=RIGHT>{{ $data->accountant_full_name }}</TD>
            </TR>

    </TBODY>
</TABLE>
<!-- ************************************************************************** -->
<br><br><br><br>

</BODY>

</HTML>

