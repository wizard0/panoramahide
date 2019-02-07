@extends('layouts.reader')

@section('content')

    <div id="reader-menu">
        @include('reader.components.sidebar', [
            'oArticles' => $oArticles
        ])
    </div>
    <div id="reader" class="panel">
        <div id="reader-header">
            @include('reader.components.header')
        </div>
        <div id="reader-panel">
            {{-- Обложка --}}
            <div class="panel-cover">
                <img class="panel-cover" src="{{ $oRelease->cover }}">
            </div>
            {{-- Контент --}}
            <div class="container js-toc-content">
                <!--Блок закладок-->
                <div class="bookmarks-holder"></div>
                <!--Блок закладок-->

                <!--Оглавление-->
                <nav>
                    <div class="contents">
                        <div>
                            <span class="contents-title" id="content-title">Содержание</span>
                        </div>
                        @foreach($oArticles as $oArticle)
                            <div class="heading">
                                <a href="#article{{ sprintf("%02d", $oArticle->id) }}">{{ $oArticle->name }}</a>
                            </div>
                            @if(count($oArticle->authors) !== 0)
                                @foreach($oArticle->authors as $oAuthor)
                                    <div class="contents-author">
                                        <p>{{ $oAuthor->name }},</p>
                                    </div>
                                @endforeach
                            @endif
                            {{--<div class="contents-link">--}}
                                {{--<a href="#article{{ sprintf("%02d", $oArticle->id) }}">Об информационной системе ценообразования</a>--}}
                            {{--</div>--}}
                            @if(!is_null($oArticle->description))
                                <div class="announce">
                                    <p>{{ $oArticle->description }}</p>
                                </div>
                            @endif
                        @endforeach

                        {{--<div class="heading">--}}
                            {{--<a href="#article00">Колонка главного редактора</a>--}}
                        {{--</div>--}}
                        {{--<div class="contents-author">--}}
                            {{--<p>Д. Н. Силка,</p>--}}
                        {{--</div>--}}
                        {{--<div class="contents-link">--}}
                            {{--<a href="#article00">Об информационной системе ценообразования</a>--}}
                        {{--</div>--}}
                        {{--<div class="heading">--}}
                            {{--<a href="#article01">События. Факты. Комментарии</a>--}}
                        {{--</div>--}}
                        {{--<div class="contents-link">--}}
                            {{--<a href="#article01">События. Факты. Комментарии</a>--}}
                        {{--</div>--}}
                        {{--<div class="heading">--}}
                            {{--<a href="#article02">Практика ценообразования</a>--}}
                        {{--</div>--}}
                        {{--<div class="contents-author">--}}
                            {{--<p>Соснаускене О. И.,</p>--}}
                        {{--</div>--}}
                        {{--<div class="contents-author">--}}
                            {{--<p>Шармин Д. В.,</p>--}}
                        {{--</div>--}}
                        {{--<div class="contents-author">--}}
                            {{--<p>Шерстнева Г. С.,</p>--}}
                        {{--</div>--}}
                        {{--<div class="contents-link">--}}
                            {{--<a href="#article02">О выборе политики в ценообразовании</a>--}}
                        {{--</div>--}}
                        {{--<div class="announce">--}}
                            {{--<p>Для повышения конкурентоспособности предприятия ему необходимо иметь гибкий подход к стратегии ценообразования. В этой связи требуется определенная политика при принятии решений. В статье рассматриваются способы выбора политики ценообразования, даются примеры по обоснованию эффективных пропорций затрат.</p>--}}
                        {{--</div>--}}
                        {{--<div class="heading"><a href="#article03">ПРАКТИКА ЦЕНООБРАЗОВАНИЯ</a></div><div class="contents-author"><p>Журавлев П. А.,</p></div><div class="contents-author"><p>Сборщиков С. Б.,</p></div><div class="contents-link"><a href="#article03">Использование ресурсно-технологического моделирования при обосновании инвестиций</a></div><div class="announce"><p>Статья раскрывает вопросы применения нормативов цены строительства (НЦС) и нормативы цены конструктивных решений (НЦКР). Показаны основные положения разработки данных нормативов, базирующиеся на ресурсно-технологическом моделировании. Выделены требования, позволяющие осуществить разработку качественных ресурсно-технологических моделей с возможностью использования разнообразной степени укрупнения и др.</p></div><div class="heading"><a href="#article04">Финансирование строительства</a></div><div class="contents-author"><p>Лукманова И. Г.,</p></div><div class="contents-author"><p>Андриенко А. О.,</p></div><div class="contents-link"><a href="#article04">Финансовый контроль и аудит в рамках проектов, реализуемых с привлечением кредитных средств</a></div><div class="announce"><p>В статье проанализированы методы проведения финансового аудита в рамках строительного контроля проектов, реализуемых с привлечением кредитных средств, в современных условиях. Рассмотрены соотношение различных процедур строительного контроля, проведение финансового контроля и организационно-технические факторы, влияющие на инвестиционно-строительные проекты.</p></div><div class="heading"><a href="#article05">Экономика строительства</a></div><div class="contents-author"><p>Бурова О. А.,</p></div><div class="contents-author"><p>Дмитриенко Р. А.,</p></div><div class="contents-link"><a href="#article05">Оценка перспектив развития строительства на современном этапе</a></div><div class="announce"><p>Современное состояние строительной отрасли характеризуется отрицательной динамикой экономических показателей деятельности строительных предприятий. Выявлены тенденции деловой активности строительных предприятий с использованием системы статистических показателей, определены проблемы и пути их решения в современных условиях.</p></div><div class="heading"><a href="#article06">Экономика строительства</a></div><div class="contents-author"><p>Канхва В. С.,</p></div><div class="contents-author"><p>Стрельцова Н. В.,</p></div><div class="contents-link"><a href="#article06">Редевелопмент промышленно занятых территорий в городе Москве</a></div><div class="announce"><p>В статье проанализированы тенденции реализации проектов редевелопмента промышленных зон в Москве в современных условиях. Рассмотрены ключевые подходы к преобразованию промышленных территорий. Обозначены основные этапы проведения процесса редевелопмента. Выявлен ряд проблем, которые могут возникать в ходе реализации проекта. Составлен прогноз дальнейшего состояния процессов редевелопмента промышленных территорий в Москве.</p></div><div class="heading"><a href="#article07">Экономика строительства</a></div><div class="contents-author"><p>Хелдман Ким,</p></div><div class="contents-link"><a href="#article07">О вопросах приобретения материалов, оборудования и резервов</a></div><div class="announce"><p>В крупной компании, в том числе поддерживающей концепцию управления проектами, существует масса задач, которые можно эффективно решить при условии достаточно грамотной предварительной формализации. В статье приводится пример осуществления подготовительных работ при закупке программного обеспечения.</p></div><div class="heading"><a href="#article08">Автоматизация в строительстве</a></div><div class="contents-author"><p>Яськова Н. Ю.,</p></div><div class="contents-author"><p>Мурашова О. В.,</p></div><div class="contents-link"><a href="#article08">BIM-технологии в строительной организации</a></div><div class="announce"><p>В статье определены основные тенденции развития инвестиционно-строительной сферы при высокой интенсивности развития внешней среды. Предложено основное направление в системе управления проектами за счет формирования и использования информационной модели. В результате выявлены основные преимущества и перспективы ее внедрения в инвестиционно-строительную отрасль.</p></div><div class="heading"><a href="#article09">Диалог с властью</a></div><div class="contents-link"><a href="#article09">Михаил Мень: Надо привыкать жить в нормальных условиях</a></div><div class="heading"><a href="#article10">Консультации в сфере закупочной деятельности</a></div><div class="contents-link"><a href="#article10">Изменения и дополнения в области реализации положений закона № 44-ФЗ для государственных закупок</a></div><div class="heading"><a href="#article11">Документы</a></div><div class="contents-link"><a href="#article11">ПРАВИТЕЛЬСТВО РОССИЙСКОЙ ФЕДЕРАЦИИ</a></div><div class="announce"><p>Постановление от 25 ноября 2013 г. № 1063</p></div><div class="heading"><a href="#article12">Документы</a></div><div class="contents-link"><a href="#article12">ПРАВИТЕЛЬСТВО РОССИЙСКОЙ ФЕДЕРАЦИИ </a></div><div class="announce"><p>Постановление от 15 мая 2017 г. № 570</p></div><div class="heading"><a href="#article13">Документы</a></div><div class="contents-link"><a href="#article13">МИНИСТЕРСТВО СТРОИТЕЛЬСТВА И ЖИЛИЩНО-КОММУНАЛЬНОГО ХОЗЯЙСТВА РОССИЙСКОЙ ФЕДЕРАЦИИ. Письмо от 25 мая 2017 г. № 18331-ММ/02</a></div></div>--}}
                {{----}}
                </nav>

                @foreach($oArticles as $oArticle)
                    {!! $oArticle->html !!}
                @endforeach
            </div>
        </div>
        <div id="reader-footer">
            @include('reader.components.footer')
        </div>
    </div>



@endsection
