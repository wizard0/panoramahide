@extends('layouts.app')

@section('content')
    <div class="cover" style="background: url(/img/cover-bg.jpg) center center no-repeat;">
        <div class="container h-100">
            <form method="GET" action="/search/" id="search_form_index" class="h-100">
                <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                    <div class="row justify-content-center w-100">
                        <div class="col-xl-6 col-lg-6 col-12 text-center">
                            <div class="search-intro">
                                <span>Поиск среди статей и изданий в информационной системе «Панорама»</span>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center w-100 simple-search search-form">
                        <input class="col-xl-6 col-lg-6 col-md-6 col-12 rightsharp" type="text" placeholder="Например, кормление сельскохозяйственных животных" name="q">
                        <select class="searcharea col-xl-2 col-lg-2 col-md-2 col-12 bothsharp" name="search_in">
                            <option value="all"  selected="selected"  >везде</option>
                            <option value="name"  >по заголовкам</option>
                            <option value="text"  >по текстам</option>
                        </select>
                        <button type="submit" class="col-xl-2 col-lg-2 col-md-2 col-6 leftsharp">
                            <span>искать</span>
                        </button>
                    </div>
                    <div class="row justify-content-center">
                        <a href="/search/?extend=1" class="col-auto cover-ghost-button advanced-search"><span>расширенный поиск</span></a>
                        <a href="/categories/" class="col-auto cover-ghost-button"><span>журналы по категориям</span></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="banners">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <a href="http://panor.ru/football/">
                        <img src="/upload/iblock/93c/93c8a40337fea0270974b13e2d327172.png" alt="Футбол">
                    </a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <a href="http://panor.ru/landing-awards/">
                        <img src="/upload/iblock/1ea/1ea9b1a792c3dd3eb7179097928f0ef0.png" alt="Новые герои новой России">
                    </a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <a href="http://panor.ru/news/i-gryanul-zalp.html">
                        <img src="/upload/iblock/3d9/3d9e7dc251a3abd38235f46351bd347e.png" alt="И грянул залп">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="holder latest-issues">
        <h2 class="text-uppercase text-center">Новые журналы</h2>
        <div class="container">
            <div class="row">
                @foreach ($lastReleases as $release)
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="row mainpage-issue align-items-center">
                        <div class="issue-image col-12">
                            <a href="{{ $release->getUrl() }}" class="d-block">
                                <img src="{{ $release->image }}">
                            </a>
                        </div>
                        <div class="issue-number col-12">{{ $release->number }}</div>
                        <div class="issue-title col-12">
                            <a href="{{ $release->getUrl() }}" class="black-link">
                                {{ $release->name }}						</a>
                        </div>
                        <div class="issue-price col-6">{{ $release->price_for_electronic }} <span>р.</span></div>
                        <div class="col-6 issue-to-cart">
                            <a  href="javascript:void(0);"
                                class="red-link _access_number addToCart"
                                data-id="{{ $release->id }}"
                                data-version="<?= Cart::VERSION_ELECTRONIC ?>"
                                data-product-type="<?= Cart::PRODUCT_TYPE_RELEASE ?>"
                            >
                                В корзину
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <a href="/search/?type=magazine&extend=1" class="more d-block"><span>Все журналы</span></a>
                </div>
            </div>
        </div></div>
    <div class="holder">
        <div class="container">
            <div class="row">
                <div class="col-lg-8"><div class="latest-articles">
                        <h2 class="text-uppercase text-center">Новые статьи</h2>
                        <div class="article-item">
                            <h3>
                                <a href="/articles/kalendar_delovykh_meropriyatiy_po_selskomu_khozyaystvu_na_dekabr_2018_goda_423398_article_0011.html.html" class="black-link">Календарь деловых мероприятий по сельскому хозяйству на декабрь 2018 года</a>
                            </h3>
                            <div class="announce">
                                <p></p>
                            </div>
                            <div class="output">
                                <div class="out-magazine">
                                    <span>Журнал:</span>
                                    <a href="/magazines/normirovanie-i-oplata-truda-v-selskom-khozyaystve/numbers/423398.html" class="grey-link">
                                        Нормирование и оплата труда в сельском хозяйстве, №11							, 2018						</a>
                                </div>
                            </div>
                        </div>
                        <div class="article-item">
                            <h3>
                                <a href="/articles/vopros_otvet_423398_article_0010.html.html" class="black-link">Вопрос — ответ</a>
                            </h3>
                            <div class="announce">
                                <p><p>В каких случаях и в каком размере  работодатель вправе производить  удержания из зарплаты?</p><p>Перечень случаев удержаний,  которые может производить работодатель  без согласия работника  из заработной платы работника, закрытый  и расширительному толкованию  не подлежит.</p></p>
                            </div>
                            <div class="output">
                                <div class="out-magazine">
                                    <span>Журнал:</span>
                                    <a href="/magazines/normirovanie-i-oplata-truda-v-selskom-khozyaystve/numbers/423398.html" class="grey-link">
                                        Нормирование и оплата труда в сельском хозяйстве, №11							, 2018						</a>
                                </div>
                            </div>
                        </div>
                        <div class="article-item">
                            <h3>
                                <a href="/articles/git_inform_423398_article_0009.html.html" class="black-link">ГИТ-информ</a>
                            </h3>
                            <div class="announce">
                                <p></p>
                            </div>
                            <div class="output">
                                <div class="out-magazine">
                                    <span>Журнал:</span>
                                    <a href="/magazines/normirovanie-i-oplata-truda-v-selskom-khozyaystve/numbers/423398.html" class="grey-link">
                                        Нормирование и оплата труда в сельском хозяйстве, №11							, 2018						</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="/articles/" class="more d-block">
                                <span>Все статьи</span>
                            </a>
                        </div>
                    </div></div>

                <div class="col-xl-2 col-lg-2 offset-xl-1 offset-lg-1">
                    <div class="sidebar-sections-menu">
                        <span class="text-uppercase">Журналы по темам</span>
                        <ul>
                            <li><a href="?category=69" class="_articles_by_category">Медицина</a></li>
                            <li><a href="?category=70" class="_articles_by_category">Охрана труда</a></li>
                            <li><a href="?category=71" class="_articles_by_category">Сельское хозяйство</a></li>
                            <li><a href="?category=72" class="_articles_by_category">Органы власти</a></li>
                            <li><a href="?category=73" class="_articles_by_category">Сфера обслуживания</a></li>
                            <li><a href="?category=74" class="_articles_by_category">Транспорт</a></li>
                            <li><a href="?category=75" class="_articles_by_category">Промышленность</a></li>
                            <li><a href="?category=76" class="_articles_by_category">Строительство</a></li>
                            <li><a href="?category=224" class="_articles_by_category">Экономика</a></li>
                            <li><a href="?category=769" class="_articles_by_category">Бухучет</a></li>
                            <li><a href="?category=223" class="_articles_by_category">Наука и культура</a></li>
                            <li><a href="?category=765" class="_articles_by_category">Юридические консультации</a></li>
                        </ul>				</div>
                </div>

            </div>
        </div>
    </div>

    {{--</div>--}}
@endsection
