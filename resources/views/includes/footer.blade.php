<div id="modals">
    @if (!Auth::check())
        @include('includes.modals.register')
    @endif
    @include('includes.modals.common')
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12 col-8 order-1 order-md-1 order-lg-1 order-xl-1 logo-wrapper">
                <div class="logo-footer">
                    <img src="/img/ru/logo-footer.svg">
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-6 order-2 order-md-2 order-lg-2 order-xl-2 f-block">
                <div class="fwrapper">
                    <span>Панорама</span>
                    <ul>
                        <li><a href="">Об издательстве</a></li>
                        <li><a href="">Награды</a></li>
                        <li><a href="">Правила публикации</a></li>
                        <li><a href="">Контакты</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-6 order-3 order-md-3 order-lg-2 order-xl-2 f-block">
                <span>Доставка и реклама</span>
                <ul>
                    <li><a href="">Оплата и доставка</a></li>
                    <li><a href="">Реклама</a></li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-12 order-4 order-md-4 order-lg-4 order-xl-4 f-block">
                <span>Мы в соцсетях</span>
                <div class="d-flex socials">
                    <div>
                        <a href="http://vk.com/">
                            <img src="/upload/iblock/81e/81e626c121b5b1d3f353dfc3f71171f7.png" alt="VK">
                        </a>
                    </div>
                    <div>
                        <a href="http://fb.com/">
                            <img src="/upload/iblock/21e/21e033213b497f92f43c6e5c26fcc690.png" alt="Facebook">
                        </a>
                    </div>
                    <div>
                        <a href="http://twitter.com/">
                            <img src="/upload/iblock/ffb/ffbe5288d412464c3502a0f75f0acf71.png" alt="twitter">
                        </a>
                    </div>
                </div>				</div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-sm-4 col-12">
                <span>Наш адрес:</span>
                <p>Москва, м. «Савёловская», Бумажный пр-д, д. 14, стр. 2, подъезд 3, этаж 6</p>
            </div>
            <div class="col-xl-3 col-lg-3 col-sm-4 col-12">
                <span>Подписка:</span>
                <p>
                    podpiska@panor.ru					</p>
            </div>
            <div class="col-xl-3 col-lg-3 col-sm-4 col-12">
                <span>Реклама:</span>
                <p>+7 495 274-22-22, доб. 39 					reklama@panor.ru</p>
            </div>
        </div>
    </div>
    <div class="holder partners">
        <div class="container">
            <div class="row justify-content-around ">
                <div class="col-12">
                    <h2 class="text-uppercase text-center">Наши партнеры</h2>
                </div>
                <div class="part-item col-auto">
                    <a href="/bitrix/rk.php?id=311&amp;site_id=s1&amp;event1=banner&amp;event2=click&amp;event3=1+%2F+%5B311%5D+%5BMAINPAGE_BANNER%5D+V+%D0%B2%D1%81%D0%B5%D1%80%D0%BE%D1%81%D1%81%D0%B8%D0%B9%D1%81%D0%BA%D0%B8%D0%B9+%D1%84%D0%BE%D1%80%D1%83%D0%BC+%D1%83%D0%BF%D0%BE%D0%BB%D0%BD%D0%BE%D0%BC%D0%BE%D1%87%D0%B5%D0%BD%D0%BD%D1%8B%D1%85+%D0%BE%D0%BF%D0%B5%D1%80%D0%B0%D1%82%D0%BE%D1%80%D0%BE%D0%B2&amp;goto=http%3A%2F%2Fwww.aeoforum.ru+"  target="_blank"  title="V всероссийский форум уполномоченных экономических операторов">
                        <img alt="V всероссийский форум уполномоченных экономических операторов" src="/upload/rk/3c0/3c07e33dd688d451c94e6cdfee4dc720.gif"/>
                    </a>
                </div>
                <div class="part-item col-auto">
                    <a href="/bitrix/rk.php?id=306&amp;site_id=s1&amp;event1=banner&amp;event2=click&amp;event3=1+%2F+%5B306%5D+%5BJOURNALS_BANNER%5D+%D0%A0%D0%BE%D1%81%D0%B0%D0%B3%D1%80%D0%BE%D0%B4%D0%B5%D0%BB&amp;goto=https%3A%2F%2Fwww.rosagrodel.ru"  target="_blank"  title="Росагродел">
                        <img alt="Росагродел" src="/upload/rk/8bb/8bb1c9826f5abff5f4174a5c1013e22d.jpg"/>
                    </a>
                </div>
                <div class="part-item col-auto">
                    <a href="/bitrix/rk.php?id=194&amp;site_id=s1&amp;event1=banner&amp;event2=click&amp;event3=1+%2F+%5B194%5D+%5BMAINPAGE_BANNER%5D+%D0%91%D0%B8%D0%B7%D0%BD%D0%B5%D1%81+%D1%84%D0%BE%D1%80%D1%83%D0%BC+modern-bakery&amp;goto=http%3A%2F%2Fmodern-bakery-moscow.ru.messefrankfurt.com%2Fmoscow%2Fru%2Fexhibitors%2Fevents%2Fbusiness_forum.html%3Futm_source%3Dobchepit%26utm_campaign%3Dmb17%26utm_medium%3Dbanner"  target="_blank"  title="Бизнес форум modern-bakery">
                        <img alt="Бизнес форум modern-bakery" src="/upload/rk/893/893d860942fb713c4ce8032bbe9d03bf.jpg"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    var CartManager = new JSCartManager();
</script>
