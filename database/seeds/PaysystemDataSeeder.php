<?php

use Illuminate\Database\Seeder;

class PaysystemDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roboID = \App\Models\Paysystem::getByCode(\App\Models\Paysystem::ROBOKASSA)->id;
        DB::table('paysystem_data')->insert([
            'name' => 'Логин магазина',
            'code' => 'shop_login',
            'value' => 'idpanor',
            'paysystem_id' => $roboID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Пароль магазина',
            'code' => 'shop_pass',
            'value' => '73utJYHzw9AWfQh',
            'paysystem_id' => $roboID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Пароль магазина №2',
            'code' => 'shop_pass2',
            'value' => '2HsJ09fNEcAUdcf',
            'paysystem_id' => $roboID
        ]);

        $sberbankID = \App\Models\Paysystem::getByCode(\App\Models\Paysystem::SBERBANK)->id;
        DB::table('paysystem_data')->insert([
            'name' => 'Банковские реквизиты',
            'code' => 'requisites',
            'value' => '044525593',
            'paysystem_id' => $sberbankID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Номер кор./сч. банка получателя платежа',
            'code' => 'invoice_bank_num',
            'value' => '30101810200000000593',
            'paysystem_id' => $sberbankID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Наименование банка',
            'code' => 'bank_name',
            'value' => 'АО "АЛЬФА-БАНК" Г. МОСКВА',
            'paysystem_id' => $sberbankID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Номер счета получателя платежа',
            'code' => 'invoice_num',
            'value' => '40702810601600002598',
            'paysystem_id' => $sberbankID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'КПП получателя платежа',
            'code' => 'KPP',
            'value' => '772901001',
            'paysystem_id' => $sberbankID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'ИНН получателя платежа',
            'code' => 'INN',
            'value' => '7729601370',
            'paysystem_id' => $sberbankID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Наименование получателя платежа',
            'code' => 'uname',
            'value' => 'ООО Издательский Дом "ПАНОРАМА"',
            'paysystem_id' => $sberbankID
        ]);

        $invoiceID = \App\Models\Paysystem::getByCode(\App\Models\Paysystem::INVOICE)->id;
        DB::table('paysystem_data')->insert([
            'name' => 'Подпись генерального директора',
            'code' => 'CEO_signature',
            'value' => '/storage/paysystem_invoice/ceo_sign.png',
            'type' => \App\Models\PaysystemData::TYPE_FILE,
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Должность бухгалтера',
            'code' => 'accountant_position',
            'value' => 'Главный бухгалтер',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Корреспондентский счет',
            'code' => 'correspondent_account',
            'value' => '30101810200000000593',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'БИК компании-поставщика',
            'code' => 'BIC',
            'value' => '044525593',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Должность руководителя',
            'code' => 'manager_position',
            'value' => 'Генеральный директор',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Печать',
            'code' => 'stamp',
            'value' => '/storage/paysystem_invoice/stamp.png',
            'type' => \App\Models\PaysystemData::TYPE_FILE,
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Подпись главного бухгалтера',
            'code' => 'chief_accountant_sign',
            'value' => '/storage/paysystem_invoice/chief_accountant_sign.png',
            'type' => \App\Models\PaysystemData::TYPE_FILE,
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Город банка',
            'code' => 'bank_city',
            'value' => 'г. Москва',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'ФИО руководителя',
            'code' => 'manager_full_name',
            'value' => 'Москаленко К.А.',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'ФИО бухгалтера',
            'code' => 'accountant_full_name',
            'value' => 'Москаленко Л.В.',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Телефон компании-поставщика',
            'code' => 'phone',
            'value' => '(495) 664-27-09',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Комментарий к счету 1',
            'code' => 'comment1',
            'value' => 'В случае непоступления средств на расчетный счет продавца в течение пяти банковских дней со дня выписки счета, продавец оставляет за собой право пересмотреть отпускную цену товара в рублях пропорционально изменению курса доллара и выставить счет на доплату. В платежном поручении обязательно указать номер и дату выставления счета. Получение товара только после прихода денег на расчетный счет компании.',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'КПП компании-поставщика',
            'code' => 'KPP',
            'value' => '772901001',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'ИНН компании-поставщика',
            'code' => 'INN',
            'value' => '7729601370',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Банк поставщика',
            'code' => 'supplier_bank',
            'value' => 'АО "АЛЬФА-БАНК"',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Адрес компании-поставщика',
            'code' => 'supplier_address',
            'value' => '119602, Москва г, Академика Анохина ул, дом № 34, корпус 2, кв.366',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Название компании-поставщика',
            'code' => 'supplier_name',
            'value' => 'Общество с ограниченной ответственностью Издательский Дом "ПАНОРАМА"',
            'paysystem_id' => $invoiceID
        ]);
        DB::table('paysystem_data')->insert([
            'name' => 'Расчетный счет компании-поставщика',
            'code' => 'supplier_current_account',
            'value' => '40702810601600002598',
            'paysystem_id' => $invoiceID
        ]);

        $robokassa = \App\Models\Paysystem::getByCode(\App\Models\Paysystem::ROBOKASSA);
        $robokassa->logo = '/storage/paysystem_logo/robokassa.jpg';
        $robokassa->save();
        $sberbank = \App\Models\Paysystem::getByCode(\App\Models\Paysystem::SBERBANK);
        $sberbank->logo = '/storage/paysystem_logo/sberbank.jpg';
        $sberbank->save();
        $invoice = \App\Models\Paysystem::getByCode(\App\Models\Paysystem::INVOICE);
        $invoice->logo = '/storage/paysystem_logo/invoice.png';
        $invoice->save();
    }
}
