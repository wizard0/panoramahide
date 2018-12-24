@extends('layouts.app')

@section('content')
<div class="container"></div>

@include('includes.searchbar')

<div class="show-results">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-12 order-1 order-xl-1 order-lg-1">
                <div class="head-of-show-results">
                    <div class="results-count">
                        <span>Найдено <span>{{ Journal::count() }}</span> журнала</span>
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                            <select name="sort">
                                <option value="DATE_CREATE-DESC"
                                        @if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'created_at')
                                            selected="selected"
                                        @endif
                                >По дате (сначала новые)</option>
                                <option value="NAME-ASC"
                                        @if (!isset($_GET['sort_by']) || $_GET['sort_by'] == 'name')
                                            selected="selected"
                                        @endif
                                >По алфавиту</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-6">
                            <div class="view-type">
                                <div class="row no-gutters justify-content-end">
                                    <input id="row-view" type="radio" name="view-type" checked="checked"/><label class="rightsharp" for="row-view" value="row-view"></label>
                                    <input id="grid-view" type="radio" name="view-type"/>
                                    <label class="leftsharp" for="grid-view" value="grid-view"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row col-xl-9 col-lg-9 col-12 order-3 order-xl-2 order-lg-2">
                @foreach ($journals as $journal)
                <div class="magazine-item entity-item d-flex col-12 _magazine"
                     data-id="{{ $journal->id }}"
                     data-link="/magazines/##.html"
                     data-link-subscribe="/magazines/##.html#subscribe">
                    <div class="checkbox-col">
                        <input id="magazine-index-{{ $journal->id }}" type="checkbox" name="article-choise" data-type="journal" value="{{ $journal->id }}" />
                        <label for="magazine-index-{{ $journal->id }}"></label>
                    </div>
                    <div class="article-info-col">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2 col-12">
                                <div class="issue-image">
                                    <a href="/magazines/##.html">
                                        <img src="{{ $journal->image }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-10 col-12">
                                <h3><a href="/magazines/##.html" class="black-link journalName">{{ $journal->name }}</a></h3>
                                <div class="announce">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="magazine-footer row justify-content-between align-items-center no-gutters">
                            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-3 col-12 out-issn">
                                <span>ISSN:</span>{{ $journal->issn }}							</div>
                            <div class="d-flex col-xl-8 col-lg-8 col-md-4 col-sm-6 col-12 goto-issue justify-content-xl-center justify-content-lg-center justify-content-md-center justify-content-sm-center justify-content-start">
                                <span>к номеру:</span>
                                <select name="number">
                                    @foreach ($journal->releases as $release)
                                        <option value="/magazines/{{  $journal->code }}/numbers/##.html">№ {{ $release->number }}, {{ $release->year }}</option>
                                    @endforeach
                                </select>
                                <a href="" class="_go_to_number_3697">перейти</a>
                            </div>
                            <div class="d-flex col-xl-2 col-lg-2 col-md-4 col-sm-3 col-12 get-access-red justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-sm-end justify-content-start">
                                <a href="/magazines/avtotransport-ekspluatatsiya-obsluzhivanie-remont.html#subscribe" class="red-link">получить доступ</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="w-100 pagination d-flex justify-content-center">
                    {{ $journals->links() }}
                    {{--<ul>--}}
                        {{--<li><span class="d-block">1</span></li>--}}

                        {{--<li><a href="/magazines/?PROPERTY_PUBLISHER=793&amp;PAGEN_1=2" class="black-link">2</a></li>--}}

                        {{--<li><a href="/magazines/?PROPERTY_PUBLISHER=793&amp;PAGEN_1=3" class="black-link">3</a></li>--}}

                        {{--<li>...</li>--}}
                        {{--<li><a href="/magazines/?PROPERTY_PUBLISHER=793&amp;PAGEN_1=11" class="black-link">11</a></li>--}}
                    {{--</ul>--}}
                </div>

            </div>

            @include('includes.sidebar')

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
                        <a href="/magazines/ovoshchevodstvo-i-teplichnoe-khozyaystvo/numbers/438945.html" class="d-block">
                            <img src="{{ $release->image }}">
                        </a>
                    </div>
                    <div class="issue-number col-12">№{{ $release->number }} / {{ $release->year }}</div>
                    <div class="issue-title col-12">
                        <a href="/magazines/ovoshchevodstvo-i-teplichnoe-khozyaystvo/numbers/438945.html" class="black-link">
                            {{ $release->name }}						</a>
                    </div>
                    <div class="issue-price col-6">{{ $release->price_for_electronic }} <span>р.</span></div>
                    <div class="col-6 issue-to-cart">
                        <a  href="/magazines/ovoshchevodstvo-i-teplichnoe-khozyaystvo/numbers/438945.html"
                            class="red-link _access_number"
                            data-id="438945"
                            data-type="electron"
                        >
                            В корзину						</a>
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
</div>
@endsection

@section('javascript')
<script>
    var SideBarManager = new JSSideBarManager();
</script>
@endsection
