# Промокоды

## ФАЙЛЫ:

| Файл | Описание |
|------|----------|
|`/promo.panor.ru/index.php`                                      |страница ввода и подтверждения промокода
|`/promo.panor.ru/ajax.php`                                       |общение этой страницы с сервером
|`/html/api/classes/promoCode.php`                                |класс для работы с сущностью "Промокод"
|`/html/api/classes/promoUser.php`                                |класс для работы с сущностью "Промо-участник"
|`/html/api/classes/promoSelect.php`                              |класс для работы с выбранными журналами по промокодам типа "Выборочный"
|`/html/promo/index.php`                                          |страница выбора  журналов по промокодам типа "Выборочный"
|`/html/bitrix/templates/panor2016/components/bxcert/empty/promo/`|компонент для выбора  журналов по промокодам типа "Выборочный"
|`/html/ajax/promo.php`                                           |общение этой страницы с сервером

## ОПИСАНИЕ:

### Сущности:

## Промокод.

### Свойства:

| Свойство | Описание |
|----------|----------|
|код                     | уникальный, сам промокод
|активность              | логическое
|вид                     | обязательный, список (о вариантах будет написано ниже)
|издательство            | множественное, привязка к Издательство
|журнал                  | привязка к Журнал
|выпуски                 | привязка к Выпуск, множественное
|лимит использований     | максимальное количеств использований промокода. Если пустое или 0, то неограниченное число использований
|использован             | сколько раз использовали этот промокод
|журнал для выпусков     | привязка к Журнал
|дата начала выпусков    | дата
|дата окончания выпусков | дата
|журналы для выбора      | привязка к Журнал, множественное, с названием группы (строка).
|сколько можно выбрать   | число

## Промо-участник.

### Свойства:

| Свойство | Описание |
|----------|----------|
|имя (фио)                | обязательное
|пользователь             | обязательное, уникальное, привязка к пользователю (стандартная авторизация на сайте)
|телефон                  |
|активированные промокоды | привязка к Промокод, множественное, список активированных пользователем промокодов.
|издательство             | привязка к Издательство, множественное, выбранные пользователем издательства
|открытые выпуски         | привязка к Выпуск, множественное, список открытых пользователем выпусков

## Выбранные журналы по промокоду.

### Свойства:

| Свойство | Описание |
|----------|----------|
|пользователь | обязательное, привязка к Промо-участник
|промокод     | обязательное, привязка к Промокод
|журнал       | привязка к Журнал, множественное

### Общий алгоритм работы:

Страница активации промокода - [http://promo.panor.ru](http://promo.panor.ru)

На ней пользователь вводит данные: ФИО, email, телефон, промокод. Все поля обязательные.
При нажатии на "получить доступ" проверяется доступность промокода: существует, активен, не исчерпан лимит использований,
не активировал ли уже этот пользователь этот промокод. Также выводится выбор издательства/журнала/выпуска,
если того требует вид промокода. Если код доступен, то на указанный номер телефона отправляется код подтверждения,
и открывается окно для ввода этого кода. Если код подтверждения введен верно, то происходит создание промо-участника
и использования кода.

Если пользователь не авторизован, то ищется пользователь с таким же email. Если найден, то открывается окно для ввода пароля.
Если не найден, то пользователь создается, используются данные из формы. Пользователь автоматически авторизуется.
Если пользователь уже авторизован, то данные из формы записываются в его профиль.

Затем проверяется, является ли текущий пользователь промо-участником (есть запись "Промо-участник" со значением свойства "Пользователь"
равным этому пользователю). Если не является, то создается запись "промо-участник" для этого пользователя.

Далее происходит активация промокода. У промокода увеличивается на 1 свойство "использован", промо-участнику в "активированные промокоды"
добавляется введенный промокод и при необходимости добавляется выбранное издательство.

В зависимости от вида промокода пользователю предоставляется доступ к выпускам:

| Выпуск | Описание |
|--------|----------|
| Общий                        | промо-выпуски (отмеченные как промо) журналов тех издательств, которые выбрал промо-участник.
| На журнал                    | промо-выпуски журнала, указанного в промокоде (свойство "Журнал")
| На издательство              | как и общий, но если заданы "дата начала выпусков" и "дата окончания выпусков", то они используются как ограничение по дате выхода выпусков.
| На выпуск                    | выпуски из свойства "Выпуски" + если заданы свойства "дата начала выпусков", "дата окончания выпусков" и "журнал для выпусков", то все выпуски этого журнала, вышедшие в указанный интервал
| На издательство + на выпуски | объединение выпусков вида "На издательство" и "На выпуск"
| Выборочный                   | промо-выпуски журналов из записи в "Выбранные журналы по промокоду" с привязкой к этому промокоду и этому пользователю

После активации происходит переход на страницу "**Мои журналы**", а для промокода вида "**Выборочный**" переход на страницу выбора журналов.

На странице выбора журналов (ссылка [http://panor.ru/promo/](http://panor.ru/promo/)) происходит поиск всех активированных пользователем промокодов
вида "**Выборочный**", для которых не выбраны журналы (нет записи в "**Выбранные журналы по промокоду**" или для такой записи пустое свойство "**Журнал**").
Если таких кодов больше одного то выводится список этих промокодов. Если промокод один, или пользователь выбрал промокод из списка,
то выводится список журналов для выбора из свойства "журналы для выбора", сгруппированные по названию группы, и если нет записи
в "**Выбранные журналы по промокоду**", то она создается (такая запись с пустым свойством "Журнал" будет означать, что пользователь открывал
страницу выбора журналов по этому промокоду, но не выбрал журналы). Если задано свойство "сколько можно выбрать", то пользователь может
выбрать журналов не больше чем это количество. После выбора журналов и нажатия "получить доступ" выбранные журналы записываются в
соответствующую запись "**Выбранные журналы по промокоду**" в свойство "**Журнал**".

При открытии выпуска промо-участником ему в свойство "открытые выпуски" дописывается этот выпуск.

На странице промо-участника в админке рядом с каждым значением свойства "**Активированные промокоды**" выводятся доступные по коду выпуски,
и для каждого выпуска выводится "стадия доступа" промо-участника к выпуску: открывал ли пользователь этот выпуск (он есть в списке значений свойства "**Открытые выпуски**")

---

# Читалка

## ФАЙЛЫ:

| Файл | Описание |
|------|----------|
|`/html/personal/reader/index.php` | проверка и подтверждение доступа
|`/html/personal/reader/event.php` | общение из читалки с сервером
|`/html/personal/reader/articles/` | html-файлы для читалки
|`/html/personal/reader/templates/` | шаблоны для вывода сообщений (об ошибках и т.п.)
|`/html/personal/reader/print/(index.php, js/print.js)` | формирование постраничной структуры и оглавления для вывода выпуска на печать
|`/html/bitrix/components/journal/reader/component.php` | получение и формирование данных для читалки
|`/html/bitrix/templates/panor2016/components/journal/reader/online/template.php` | шаблон
|`/html/bitrix/templates/panor2016/components/journal/reader/online/js/script.js` | js для работы читалки (подгрузка частей, общение с сервером, и т.д.)
|`/html/api/classes/bookmark.php` | класс для работы с закладками
|`/html/api/classes/readerCode.php` | класс для работы с кодами подтверждения (устройствами)
|`/html/api/classes/readable.php` | класс для работы с html-файлами (частями) для читалки

## ОПИСАНИЕ:

Электронную версию выпуска можно читать на сайте. Для этого загружается архив с файлами (html, картинки, css и т.п.).
Для доступа к читалке необходимо подтвердить устройство. Если пользователь открывает читалку, и у него не подтверждено устройство,
то на почту отправляется код подтверждения, пользователь вводит этот код на сайте, и устройство запоминается как подтвержденное
(например, запоминается в куках браузера). Максимум у пользователя может быть 2 активированных устройства.
Время жизни активированного устройства - 1 неделя, т.е. через неделю нужно будет повторно активировать устройство.
Если пользователь открывает читалку с неактивированного устройства открывает читалку, и уже исчерпан лимит активаций, то на почту
отправляется ссылка для сброса активированных устройств.

Одновременно можно читать выпуски только с одного устройства, в том числе нельзя одновременно читать разные выпуски с разных устройств.
Если пользователь открывает читалку, но она уже открыта на другом устройстве, то выводится соответствующее сообщение об ошибке.

В читалке есть содержание (собирается из заголовков читалки), закладки, библиотека (список доступных выпусков для читалки).

# Доступы для партнёров.

## Разработка необходимого API

## ФАЙЛЫ:

| Файл | Описание |
|------|----------|
|`/html/personal/reader/api/index.php` | проверка параметров доступа (партнер, пользователь, квота) для открытия читалки
|`/html/personal/reader/api/magazines.php` | выбор выпуска для чтения из списка доступных по квоте
|`/html/personal/reader/api/event.php` | общение читалки с сервером
|`/html/personal/reader/api/templates/` | шаблоны для вывода сообщений (об ошибках и т.п.)
|`/html/api/classes/partner.php` | класс для работы с сущностью "Партнер"
|`/html/api/classes/partnerQuota.php` | класс для работы с сущностью "Квота"
|`/html/api/classes/partnerUser.php` | класс для работы с сущностью "Пользователь" партнера
|`/html/api/classes/partnerDevice.php` | класс для работы устройствами пользователей партнеров, работает совместно с классом ReaderCode
|`/html/bitrix/components/journal/reader/component.php` | получение и формирование данных для читалки
|`/html/bitrix/templates/panor2016/components/journal/reader/api_online/template.php` | шаблон
|`/html/bitrix/templates/panor2016/components/journal/reader/api_online/js/script.js` | js для работы читалки (подгрузка частей, общение с сервером, и т.д.)

## ОПИСАНИЕ:

### Описание задачи:

Необходимо разработать универсальную API для доступа к журналам через наших партнеров.
Т.е. API, благодаря которому они смогут демонстрировать наши листалки через свои сайты.
Каждый партнер будет иметь свой ключ для подключения к сайту, нужно продумать простой способ инеграции,
чтобы для них это было не слишком затратно. Также нужна какая-то система учета по журналам и количеству доступов.
Партнеры врятли захотят нам передавать контактные данные подписчиков (чтобы мы их не переманили в редакционные),
но могут давать уникальный идентификационный ключ на каждого подписчика, а нам надо будет отслеживать к-во подключенных пользователей.

Блоксхема условия предоставления журнала: [https://yadi.sk/i/mXOhYKd83KBjQu](https://yadi.sk/i/mXOhYKd83KBjQu)

### Сущности:

## Партнер.

Партнер, пользователям которого предоставляется доступ к выпускам.

### Свойства:

| Свойство | Описание |
|----------|----------|
| ключ       | уникальный, обязательный
| активность | логическое

## Квота.

Настройка доступа к чтению выпусков для пользователей партнеров, здесь указывается к чему есть доступ у пользователей.

При заданном журнале также дополнительно могут быть ограничения по дате выхода выпусков этого журнала. Если заданы и журнал,
и выпуск, то доступ предоставляется и к указанному выпуску, и к выпускам указанного журнала.

При использовании квоты ей увеличивается на 1 свойство "использовано". Если свойство "использовано" больше или равно свойству
"размер квоты", то новые пользователи не смогут ее использовать, а кто её уже использовал могут продолжать ей пользоваться.

### Свойства:

| Свойство | Описание |
|----------|----------|
|ID               | уникальный, идентификатор квоты.
|партнер          | обязательный, привязка к Партнер, для какого партнера предоставляется квота
|активность       | логическое
|журнал           | привязка к журналу, на какой журнал предоставляется квота
|начало интервала | дата, доступны выпуски журнала, вышедшие после этой даты, если не задана, то нет ограничения
|конец интервала  | дата, доступны выпуски журнала, вышедшие до этой даты, если не задана, то нет ограничения
|выпуск           | привязка к Выпуск, к какому выпуску предоставляется доступ
|размер квоты     | сколько пользователей могут использовать эту квоту
|использовано     | сколько раз эту квоту уже использовали

## Пользователь.

Пользователь партнера, которому предоставляется доступ к чтению выпусков.

Пользователи партнера не являются пользователями Панорамы, но могут быть авторизованы на ней.

### Свойства:

| Свойство | Описание |
|----------|----------|
|идентификатор        | уникальный (в рамках партнером, составной ключ), обязательный, используется для идентификации пользователя
|партнер              | обязательный, привязка к Партнер, к какому партнеру относится этот пользователь
|активность           | логическое
|использованные квоты | множественное, привязка к Квота, какие квоты пользователь использовал. При повторном обращении к уже использованной квоте, ее свойство "использовано" не увеличивается, т.е. использование (списание) происходит при первом обращении пользователя к этой квоте.
|доступные выпуски    | множественное, привязка к Выпуск, список выпусков, к которым пользователь успешно получил доступ.
|email                | поста пользователя, используется для отправки кода подтверждения. Если при создании пользователя идентификатором является email-валидная строка, то в это свойство автоматически записывается идентификатор.

## Общий алгоритм работы:

По ссылке (пример [http://panor.ru/personal/reader/api/?partnerkey=foo&userkey=bar&journal=123()]http://panor.ru/personal/reader/api/?partnerkey=foo&userkey=bar&journal=123))
открывается специальная страница, на которой проверяется доступ к читалке. Передаются ключ партнера (partnerkey), идентификатор читателя (userkey),
ID квоты (journal). Проверяется ключ партнера (существует и активен), идентификатор пользователя (совпадает ли партнер. Если нет пользователя такого, то создается).

Проверяется квота: если пользователь ее уже использовал, или еще не исчерпан размер квоты, то ее можно использовать.

По ID квоты определяется к чему есть доступ. Если указан только выпуск, то он открывается. Если журнал,
то выводится список доступных по квоте выпусков (выпуски журнала, возможно с ограничением по дате выхода),
пользователь выбирает конкретный выпуск из предложенных, и он открывается.

При открытии выпуска для чтения, работает такой же алгоритм по проверке подтвержденного устройства, как
и в читалке для обычных пользователей (описан в сущности Выпуск). Но сбрасывать подтвержденные устройства
при исчерпании лимита активированных устройств нельзя. Если устройство не подтверждено, то на email этого
пользователя отправляется код подтверждения, и открывается форма для ввода этого кода. Если email пользователя
не задан, то выводится форма для ввода email, который запоминается в свойстве "email" этого пользователя.
Также проверяется нет ли других устройств в сети.

На странице пользователя партнера в админке должна выводиться информация об устройствах этого пользователя,
пример [http://prntscr.com/jroiog](http://prntscr.com/jroiog)

- "**в сети**" означает что на этом устройстве сейчас открыт журнал,
- "**обновлен**" - время когда был обновлен статус в сети
- "**был в сети**" - время, когда в последний раз был открыт журнал
- "**устарело**" - означает что "время жизни" устройства истекло (сейчас стоит 1 неделя), как и в читалке, требуется повторное подтверждение устройства
- "**код ... не найден**" - ошибка в связях базы данных, скорее всего возникать не будет, вывел на всякий случай

