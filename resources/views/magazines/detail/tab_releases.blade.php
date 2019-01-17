<div class="container">
        <div class="row justify-content-around">
            <div class="col-xl-8 col-lg-8 col-12 order-3 order-xl-2 order-lg-2">
                <div class="issue-main">
                    <div class="row">
                        <div class="col-12">

                            @include('magazines.detail.breadcrumbs', compact('journal'))

                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-12 issue-cover">
                            <img src="{{ $journal->image }}">
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                            <h3 id="journalName">Журнал "{{ $journal->name }} /
                                {{ $journal->translate('en', true)->name }}"</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="all-ussues-container">
                            <div id="accordion">

                                @foreach($releases as $year=>$releasesThatYear)
                                <div class="card">
                                    <div class="card-header">
                                        <a class="card-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#pan{{ $year }}">
                                            <span>{{ $year }}</span>{{ sizeof($releasesThatYear) }} выпусков											</a>
                                    </div>
                                    <div id="pan{{ $year }}" class="collapse">
                                        <div class="card-body">
                                            @foreach($releasesThatYear as $release)
                                            <div class="issue-line _number _share_container" data-id="{{ $release->id }}">
                                                <div class="issue-line-group">
                                                    <div class="checkbox-col">
                                                        <input id="article-index-{{ $release->id }}" type="checkbox" name="article-choise" data-type="{{ Cart::PRODUCT_TYPE_RELEASE }}" value="{{ $release->id }}">
                                                        <label for="article-index-{{ $release->id }}">
                                                        </label>
                                                    </div>

                                                    <div class="issue-num">
                                                        <a href="{{ $release->getUrl() }}" class="grey-link">№{{ $release->number }}</a>
                                                    </div>
                                                    <div class="to-fav-this"><a href="#" class="_add_to_favorite" data-id="{{ $release->id }}"></a></div>
                                                    <div class="share-this"><a href="#" class="_share" title="Поделиться"></a></div>
                                                    <div class="ya-share2 _share_block ya-share2_inited" style="display: none;"
                                                         data-services="vkontakte,facebook,odnoklassniki,twitter,gplus,telegram,whatsapp,viber"
                                                         data-limit="5"
                                                         data-url="{{ $release->getUrl() }}"
                                                         data-title="{{  $journal->name }} / {{ $journal->translate('en', true)->name }}  №{{$release->number}}"
                                                         data-image="{{ $release->image }}">
                                                        <div class="ya-share2__container ya-share2__container_size_m">
                                                            <ul class="ya-share2__list ya-share2__list_direction_horizontal">
                                                                <li class="ya-share2__item ya-share2__item_service_vkontakte">
                                                                    <a class="ya-share2__link" href="https://vk.com/share.php?url=%2Fmagazines%2Ftovaroved-prodovolstvennykh-tovarov%2Fnumbers%2F442616.html&amp;title=%D0%A2%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%D0%B5%D0%B4%20%D0%BF%D1%80%D0%BE%D0%B4%D0%BE%D0%B2%D0%BE%D0%BB%D1%8C%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D1%8B%D1%85%20%D1%82%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%20%2F%20Goods%20manager%20of%20food%20products%20%E2%84%9612&amp;image=%2Fupload%2Fiblock%2F182%2F1826e47ba3d7225149f9b4a469ee4826.png&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="ВКонтакте"><span class="ya-share2__badge"><span class="ya-share2__icon"></span><span class="ya-share2__counter"></span></span><span class="ya-share2__title">ВКонтакте</span></a></li><li class="ya-share2__item ya-share2__item_service_facebook"><a class="ya-share2__link" href="https://www.facebook.com/sharer.php?src=sp&amp;u=%2Fmagazines%2Ftovaroved-prodovolstvennykh-tovarov%2Fnumbers%2F442616.html&amp;title=%D0%A2%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%D0%B5%D0%B4%20%D0%BF%D1%80%D0%BE%D0%B4%D0%BE%D0%B2%D0%BE%D0%BB%D1%8C%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D1%8B%D1%85%20%D1%82%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%20%2F%20Goods%20manager%20of%20food%20products%20%E2%84%9612&amp;picture=%2Fupload%2Fiblock%2F182%2F1826e47ba3d7225149f9b4a469ee4826.png&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Facebook"><span class="ya-share2__badge"><span class="ya-share2__icon"></span><span class="ya-share2__counter"></span></span><span class="ya-share2__title">Facebook</span></a></li><li class="ya-share2__item ya-share2__item_service_odnoklassniki"><a class="ya-share2__link" href="https://connect.ok.ru/offer?url=%2Fmagazines%2Ftovaroved-prodovolstvennykh-tovarov%2Fnumbers%2F442616.html&amp;title=%D0%A2%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%D0%B5%D0%B4%20%D0%BF%D1%80%D0%BE%D0%B4%D0%BE%D0%B2%D0%BE%D0%BB%D1%8C%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D1%8B%D1%85%20%D1%82%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%20%2F%20Goods%20manager%20of%20food%20products%20%E2%84%9612&amp;imageUrl=%2Fupload%2Fiblock%2F182%2F1826e47ba3d7225149f9b4a469ee4826.png&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Одноклассники"><span class="ya-share2__badge"><span class="ya-share2__icon"></span><span class="ya-share2__counter"></span></span><span class="ya-share2__title">Одноклассники</span></a></li><li class="ya-share2__item ya-share2__item_service_twitter"><a class="ya-share2__link" href="https://twitter.com/intent/tweet?text=%D0%A2%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%D0%B5%D0%B4%20%D0%BF%D1%80%D0%BE%D0%B4%D0%BE%D0%B2%D0%BE%D0%BB%D1%8C%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D1%8B%D1%85%20%D1%82%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%20%2F%20Goods%20manager%20of%20food%20products%20%E2%84%9612&amp;url=%2Fmagazines%2Ftovaroved-prodovolstvennykh-tovarov%2Fnumbers%2F442616.html&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Twitter"><span class="ya-share2__badge"><span class="ya-share2__icon"></span></span><span class="ya-share2__title">Twitter</span></a></li><li class="ya-share2__item ya-share2__item_service_telegram"><a class="ya-share2__link" href="https://telegram.me/share/url?url=%2Fmagazines%2Ftovaroved-prodovolstvennykh-tovarov%2Fnumbers%2F442616.html&amp;text=%D0%A2%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%D0%B5%D0%B4%20%D0%BF%D1%80%D0%BE%D0%B4%D0%BE%D0%B2%D0%BE%D0%BB%D1%8C%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D1%8B%D1%85%20%D1%82%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%20%2F%20Goods%20manager%20of%20food%20products%20%E2%84%9612&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Telegram"><span class="ya-share2__badge"><span class="ya-share2__icon"></span></span><span class="ya-share2__title">Telegram</span></a></li><li class="ya-share2__item ya-share2__item_more"><a class="ya-share2__link ya-share2__link_more" href="#"><span class="ya-share2__badge ya-share2__badge_more"><span class="ya-share2__icon ya-share2__icon_more"></span></span></a><div class="ya-share2__popup ya-share2__popup_direction_bottom ya-share2__popup_list-direction_horizontal"><ul class="ya-share2__list ya-share2__list_direction_vertical"><li class="ya-share2__item ya-share2__item_service_whatsapp"><a class="ya-share2__link" href="https://api.whatsapp.com/send?text=%D0%A2%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%D0%B5%D0%B4%20%D0%BF%D1%80%D0%BE%D0%B4%D0%BE%D0%B2%D0%BE%D0%BB%D1%8C%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D1%8B%D1%85%20%D1%82%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%20%2F%20Goods%20manager%20of%20food%20products%20%E2%84%9612%20%2Fmagazines%2Ftovaroved-prodovolstvennykh-tovarov%2Fnumbers%2F442616.html&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="WhatsApp"><span class="ya-share2__badge"><span class="ya-share2__icon"></span></span><span class="ya-share2__title">WhatsApp</span></a></li><li class="ya-share2__item ya-share2__item_service_viber"><a class="ya-share2__link" href="viber://forward?text=%D0%A2%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%D0%B5%D0%B4%20%D0%BF%D1%80%D0%BE%D0%B4%D0%BE%D0%B2%D0%BE%D0%BB%D1%8C%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D1%8B%D1%85%20%D1%82%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%20%2F%20Goods%20manager%20of%20food%20products%20%E2%84%9612%20%2Fmagazines%2Ftovaroved-prodovolstvennykh-tovarov%2Fnumbers%2F442616.html&amp;utm_source=share2" rel="nofollow" target="_blank" title="Viber"><span class="ya-share2__badge"><span class="ya-share2__icon"></span></span><span class="ya-share2__title">Viber</span></a></li><li class="ya-share2__item ya-share2__item_copy"><a class="ya-share2__link ya-share2__link_copy" href="#"><span class="ya-share2__title">Скопировать ссылку</span></a><input class="ya-share2__input_copy" value="/magazines/tovaroved-prodovolstvennykh-tovarov/numbers/442616.html"></li></ul></div></li></ul></div></div>
                                                            {{--This is shit--}}
                                                </div>
                                                <div class="issue-line-access">
                                                    <div class="get-access-link">
                                                        <a href="#" class="_access_number" data-id="{{ $release->id }}">Получить доступ</a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-12 order-2 order-xl-3 order-lg-3">
                @include('includes.sidebar')
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $('._number._share_container ._add_to_favorite').on('click', function(e) {
            SideBarManager.addToFavorites(e, JSON.stringify([{
                id: $(e.target).data('id'),
                type: 'release'
            }]));
        });

        $('._number._share_container ._access_number').on('click', function (e) {
            var releaseID = $(e.target).data('id');
            $('#number-type form input[name="id"]').val(releaseID);
            $('#number-type').modal('show');
        });

        $(window.document).on('submit', '#number-type form', function() {
            event.preventDefault();

            var version = $(event.target).find('input[name="version"]:checked').val(),
                type = 'release',
                id = $(event.target).find('input[name="id"]').val();

            CartManager.addToCart(version, type, id);

            return false;
        });
    });
</script>
