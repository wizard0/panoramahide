<template>
    <div>
        <div id="reader-menu">
            <nav>
                <div class="nav nav-tabs nav-hidden hidden" role="tablist">
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-reader-contents" role="tab"
                       aria-controls="nav-home" aria-selected="true">
                        <span class="text-uppercase">Содержание</span>
                    </a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-reader-bookmarks" role="tab"
                       aria-controls="nav-profile" aria-selected="false">
                        <span class="text-uppercase">Закладки</span>
                    </a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-reader-library" role="tab"
                       aria-controls="nav-contact" aria-selected="false">
                        <span class="text-uppercase">Библиотека</span>
                    </a>
                </div>
            </nav>
            <div class="tab-content">
                <div class="tab-pane fade" id="tab-reader-contents" role="tabpanel">
                    <h3 class="text-uppercase text-center m-t-15 m-b-15">Содержание</h3>
                    <div class="tab-content-item" data-simplebar>
                        <div :class="{'is-loading': tab.content.loading}">
                            <ul class="content contents-nav" v-if="articles.data !== null">
                                <li class="reader-sidebar-chapter" v-for="article in articles.data">
                                    <span>
                                        <a href="#" role="button"
                                           v-scroll-to="scrollOptions(articleIdToHref(article.id))"
                                        >{{ article.name }}</a>
                                        <p v-if="article.description">{{ article.description }}</p>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-reader-bookmarks" role="tabpanel">
                    <h3 class="text-uppercase text-center m-t-15 m-b-15">Закладки</h3>
                    <div class="tab-content-item" data-simplebar>
                        <div :class="{'is-loading': tab.bookmarks.loading}">
                            <ul class="content contents-nav" v-if="bookmarks.data !== null">
                                <li class="bookmarks-list-item" v-for="(bookmark, key) in bookmarks.data">
                                    <div class="bookmark-flag">
                                        <span>{{ key + 1 }}</span>
                                    </div>
                                    <div class="bookmark-cont">
                                        <span>
                                            <a href="#" role="button"
                                               v-scroll-to="scrollOptions('#bookmark_' + bookmark.id, 0)"
                                            >
                                                {{ bookmark.title }}
                                            </a>
                                        </span>
                                    </div>
                                    <div class="bookmark-remove">
                                        <a href="#" title="Удалить закладку" @click="bookmarkRemove(bookmark.id, $event)">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-reader-library" role="tabpanel">
                    <h3 class="text-uppercase text-center m-t-15 m-b-15">Библиотека</h3>
                    <div class="tab-content-item" data-simplebar>
                        <!--<div v-if="releases.data !== null">-->
                        <div :class="{'is-loading': tab.library.loading}">
                            <ul class="content contents-nav" v-if="releases.data !== null">
                                <li class="reader-sidebar-journal d-flex align-items-center flex-column" v-for="release in releases.data">
                                    <a :href="'/reader?release_id=' + release.id" role="button"
                                       @click="getRelease(release.id)">
                                        <img :src="release.image">
                                    </a>
                                    <a :href="'/reader?release_id=' + release.id" role="button"
                                       class="text-center red-link __j-on-hover m-t-10" @click="getRelease(release.id)">
                                        <b>№{{ release.number }}/{{ release.year }}</b>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="reader" class="panel">
            <div id="reader-header">
                <header class="reader-header header-left">
                    <div class="" style="padding: 0 15px">
                        <div class="row flex-nowrap justify-content-between align-items-center">
                            <div class="col-2 col-lg-4">
                                <div class="show-less-xl hide-more-xl" v-if="!user.guest">
                                    <div class="menu-wrapper toggle-button" data-name="#tab-reader-contents">
                                        <div class="hamburger-menu"></div>
                                    </div>
                                </div>
                                <div class="hide-less-xl show-more-xl" v-if="!user.guest">
                                    <a class="text-muted toggle-button" href="#" style="margin-right: 6px;"
                                       data-name="#tab-reader-contents"
                                       @click="tabContent()"
                                    >
                                        <span class="text-uppercase contents">
                                            Содержание
                                        </span>
                                    </a>
                                    <a class="text-muted toggle-button" href="#" style="margin-right: 6px;"
                                       data-name="#tab-reader-bookmarks"
                                       @click="tabBookmarks()"
                                    >
                                        <span class="text-uppercase bookmark">
                                            Закладки
                                        </span>
                                    </a>
                                    <a class="text-muted toggle-button" href="#" style="margin-right: 6px;"
                                       data-name="#tab-reader-library"
                                       @click="tabLibrary()"
                                    >
                                        <span class="text-uppercase library">
                                            Библиотека
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-8 col-lg-4 text-center" :class="{'is-disabled' : user.guest}">
                                <div class="search mx-3" style="position: relative">
                                    <input type="text" class="form-control search-input" placeholder="Поиск по тексту">
                                    <div class="search-icon" style="position: absolute; top: 10px; right: 10px;">
                                        <a class="text-muted" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 class="__search" focusable="false" role="img">
                                                <title>Search</title>
                                                <circle cx="10.5" cy="10.5" r="7.5"></circle>
                                                <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 col-lg-4 d-flex justify-content-end align-items-center">
                                <a class="text-muted" href="#" style="margin-right: 10px;" v-if="!user.guest" @click="$root.modalShow($root.options.modal.readerBookmark)">
                                    <span class="setbookmark">
                                        <i class="hide-less-lg">В ЗАКЛАДКИ</i>
                                    </span>
                                </a>
                                <a class="text-muted" href="/logout" v-if="!user.guest">
                                    <span class="exit hide-more-lg">
                                        <i class="hide-less-lg">ВЫХОД</i>
                                    </span>
                                    <span class="empty show-more-xl hide-less-lg">
                                        ВЫХОД
                                    </span>
                                </a>
                                <a class="text-muted" href="#" data-toggle="modal" data-target="#login-modal" v-if="user.guest">
                                    <span class="exit hide-more-lg">
                                        <i class="hide-less-lg">ВОЙТИ</i>
                                    </span>
                                    <span class="empty show-more-xl hide-less-lg">
                                        ВОЙТИ
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </header>

            </div>
            <div id="reader-panel" :class="{'is-loading': articles.data === null}">
                <div class="panel-cover" v-if="release.data !== null">
                    <img class="panel-cover" :src="release.data.image">
                </div>
                <div class="container" v-if="articles.data !== null">
                    <div class="bookmarks-holder"></div>
                    <nav>
                        <div class="contents">
                            <div>
                                <span class="contents-title" id="content-title">Содержание</span>
                            </div>
                            <div v-for="article in articles.data">
                                <div class="heading">
                                    <a href="#" role="button"
                                       v-scroll-to="scrollOptions('#article0' + article.id)"
                                    >{{ article.name }}</a>
                                </div>
                                <div class="contents-author" v-for="author in article.authors">
                                    <p>{{ author.name }},</p>
                                </div>
                                <div class="announce" v-if="article.description">
                                    <p>{{ article.description }}</p>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div v-for="article in articles.data">
                        <div v-html="article.html"></div>
                    </div>
                    <div id="reader-panel-bookmarks">
                        <div class="bookmarks-holder">
                            <div :id="'bookmark_' + bookmark.id" class="bookmark-item" v-for="(bookmark, key) in bookmarks.data" :style="[{'top': bookmark.scroll + 'px'}]">
                                <span>{{ key + 1}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="reader-footer" v-if="release.data !== null">
                <div class="inform-string" style="">
                    <div class="inform-string-holder">
                        <div class="inform-string-home">
                            <a href=""></a>
                        </div>
                        <div class="inform-string-magazine">
                            <a href="#">
                                <p><span>№{{ release.data.number }}, {{ release.data.year }} </span>{{ release.data.name
                                    }}</p>
                                <div class="grad"></div>
                            </a>
                        </div>
                        <div class="grad_01"></div>
                        <div class="inform-string-article" style="overflow: visible;">
                            <p>
                                <a :href="footer.hrefDefault"
                                   v-scroll-to="scrollOptions(footer.hrefDefault)"
                                >
                                    {{ footer.headingDefault }}
                                </a>
                            </p>
                        </div>
                        <div class="inform-string-article" v-if="footer.href !== null">
                            <p id="cur_heading">
                                <a :href="footer.href"
                                   v-scroll-to="scrollOptions(footer.href)"
                                >
                                    {{ footer.heading }}
                                </a>
                            </p>
                        </div>
                        <div class="grad_02" v-if="footer.href !== null"></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <vue-modal title="Добавить закладку" :name="$root.options.modal.readerBookmark" :width="356">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input type="text" name="bookmark" placeholder="Заголовок" v-model="bookmark.title">
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <a class="btn btn-danger" @click="bookmarkAdd($event)">
                        Добавить
                    </a>
                </div>
            </div>
        </vue-modal>
    </div>

</template>

<script>
    /**
     * Импортирует библиотеки, но можно брать и глобавльные
     */
    import vueModal from './../plugins/modal-template.vue';
    import axios from 'axios';
    import slideout from 'slideout';

    export default {
        name: 'Reader',
        components: {
            'vue-modal': vueModal,
        },
        data() {
            /**
             * Данные приложения
             * В методах через this
             * В шаблонах без
             */
            return {
                /**
                 * Ссылки для запросов
                 */
                url: {
                    code: '/reader/code',
                    online: '/reader/online?online=1',
                    onlineCheck: '/reader/online',

                    release: '/reader/release',
                    releases: '/reader/releases',
                    articles: '/reader/articles',
                    bookmarks: '/reader/bookmarks',
                },

                /**
                 * Модальные окна
                 */
                modal: {
                    login: '#login-modal',
                    code: '#reader-code-modal',
                    online: '#reader-confirm-online-modal',
                    max: '#reader-max-devices-modal',
                },

                /**
                 * Пользователь
                 * - guest по window.user
                 */
                user: {},

                /**
                 * Выпуск по api
                 * вне data может хранится еще что вспомогательное
                 */
                release: {
                    /**
                     * Данные выпуска
                     */
                    data: null,
                },
                releases: {
                    data: null,
                },
                bookmarks: {
                    data: null,
                },
                articles: {
                    data: null,
                },
                bookmark: {
                    title: '',
                    article_id: 0,
                    scroll: 0,
                },

                /**
                 * Устройство
                 */
                device: {
                    hasOnline: false,
                },

                /**
                 * Вкладки в сайдбаре
                 */
                tab: {
                    content: {
                        loading: false,
                    },
                    bookmarks: {
                        loading: false,
                    },
                    library: {
                        loading: false,
                    },
                },

                /**
                 * Футер
                 */
                footer: {
                    /**
                     * Заголовок
                     */
                    heading: null,

                    /**
                     * Заголовок по умолчанию
                     */
                    headingDefault: 'Содержание',

                    /**
                     * Якорь
                     */
                    href: null,

                    /**
                     * Якорь по умолчанию
                     */
                    hrefDefault: '#content-title'
                }
            }
        },
        /**
         *
         */
        methods: {
            /**
             * Получить релиз
             */
            getRelease(id) {
                const self = this;
                let data = {};
                if (id !== undefined) {
                    data.id = id;
                }
                axios.post(self.url.release, data)
                    .then(response => {
                        self.release.data = response.data.data;
                        self.getArticles();
                        console.log(self.release);
                    })
                    .catch();
            },

            /**
             * Получить релизы
             */
            getReleases() {
                const self = this;
                if (self.releases.data !== null) {
                    return;
                }
                self.releases.data = null;
                self.tab.library.loading = true;
                axios.get(self.url.releases)
                    .then(response => {
                        self.releases.data = response.data.data;
                        self.tab.library.loading = false;
                        console.log(self.releases);
                    })
                    .catch();
            },

            /**
             * Все избранные
             */
            getBookmarks() {
                const self = this;
                let data = {};
                data.release_id = self.release.data.id;
                if (self.bookmarks.data !== null) {
                    return;
                }
                self.tab.bookmarks.loading = true;
                axios.post(self.url.bookmarks, data)
                    .then(response => {
                        self.bookmarks.data = response.data.data;
                        self.tab.bookmarks.loading = false;
                    })
                    .catch();
            },

            /**
             * Получить все статьи по выпуску
             */
            getArticles() {
                const self = this;
                let data = {};
                data.release_id = self.release.data.id;
                if (self.articles.data !== null) {
                    return;
                }
                self.articles.data = null;
                self.tab.content.loading = true;
                axios.post(self.url.articles, data)
                    .then(response => {
                        self.articles.data = response.data.data;
                        self.tab.content.loading = false;
                        console.log(self.articles);
                        window.Vue.nextTick(function () {
                            self.scrollToInit();
                        });
                        self.getBookmarks();
                    })
                    .catch();
            },

            /**
             * События для скрола, чтобы футер менялся
             */
            scrollToInit() {
                const self = this;
                $('#reader-panel').on('scroll', function () {
                    let beSet = false;
                    self.bookmark.scroll = $(this).scrollTop();
                    $('#reader-panel article').each(function () {
                        let ThisOffset = $(this).offset();
                        if (ThisOffset.top < 220) {
                            let id = $(this).find('h2').attr('id');
                            self.footerSet($(this).closest('section').find('.heading').text(), '#' + id);
                            self.bookmark.article_id = id;
                            beSet = true;
                        }
                    });
                    if (!beSet) {
                        self.footerSet(null, null);
                        self.bookmark.article_id = 0;
                    }
                });
            },

            /**
             * Определение элемента
             */
            point(x, y) {
                if (x === undefined) {
                    x = document.documentElement.clientWidth / 2;
                }
                if (y === undefined) {
                    y = $('#reader-header').height() + 100;
                }
                return document.elementFromPoint(x, y);
            },

            /**
             * Присвоить данные для футера
             */
            footerSet(title, href) {
                const self = this;
                self.footer.heading = title;
                self.footer.href = href;
            },

            /**
             * Отправить запрос с проверкой устроства
             */
            deviceCheckOnline() {
                const self = this;
                axios.get(self.url.onlineCheck)
                    .then(response => {
                        self.device.hasOnline = !response.data.success;
                        if (self.device.hasOnline) {
                            self.modalShowBootstrap(self.modal.online);
                        }
                    })
                    .catch();
            },

            /**
             * Проверка устройства каждые 5 секунд
             */
            intervalDeviceCheckOnline() {
                const self = this;
                let userDeviceSetOnline = setInterval(function () {
                    if (self.device.hasOnline) {
                        clearInterval(userDeviceSetOnline);
                    } else {
                        self.deviceCheckOnline();
                    }
                }, 5000)
            },

            /**
             * Вкладка Содержание в сайдбаре
             */
            tabContent() {
                const self = this;
                self.getArticles();
            },

            /**
             * Вкладка Избранные в сайдбаре
             */
            tabBookmarks() {
                const self = this;
                self.getBookmarks();
            },

            /**
             * Вкладка Библиотека в сайдбаре
             */
            tabLibrary() {
                const self = this;
                self.getReleases();
            },

            /**
             * Опции для переха со скролом
             */
            scrollOptions(element, offset) {
                const self = this;
                return {
                    el: element,
                    onStart: self.scrollOnStart,
                    onDone: self.scrollOnDone,
                    offset: offset !== undefined ? offset : -100,
                };
            },

            /**
             * Принудительный скрол до элемента
             */
            scrollTo(element) {
                const self = this;
                self.$scrollTo(element, 500, window.reader.scrollToOptions);
            },

            /**
             * Переход со скролом начался
             * Можно добавить закрытие сайдбара
             */
            scrollOnStart() {
                //console.log('scrollOnStart');
            },

            /**
             * Переход со скролом окончен
             */
            scrollOnDone() {
                //console.log('scrollOnDone');
            },

            /**
             * Открытие вкладки в sidebar
             */
            tabOnOpen() {
                const self = this;
                $('.nav-item').on('show.bs.tab', function () {
                    let href = $(this).attr('href');
                    if (href === '#tab-reader-contents') {
                        self.getArticles();
                    }
                    if (href === '#tab-reader-bookmark') {
                        self.getBookmarks();
                    }
                    if (href === '#tab-reader-library') {
                        self.getReleases();
                    }
                });
            },

            /**
             * Открыть бутстрап модальное окно по селектору
             */
            modalShowBootstrap(id) {
                $(id).modal('show');
            },

            /**
             * Удаление заклаки в сайдбаре
             */
            bookmarkRemove(id, event) {
                const self = this;
                self.loading(event.target.closest('a'), true);
                let data = {};
                axios.post(self.url.bookmarks + '/' + id + '/destroy', data)
                    .then(response => {
                        self.bookmarks.data = null;
                        self.getBookmarks();
                    })
                    .catch();
            },

            /**
             * Добавление закладки в модальном окне
             */
            bookmarkAdd(event) {
                const self = this;
                if (self.bookmark.title === '') {
                    window.toastr.error('Введите название закладки', 'Ошибка', {
                        closeButton: true,
                        timeOut: 3000,
                    });
                    return;
                }
                self.loading(event.target, true);
                let data = {};
                data.article_id = self.bookmark.article_id.slice(7);
                data.release_id = self.release.data.id;
                data.title = self.bookmark.title;
                data.scroll = self.bookmark.scroll;
                axios.post(self.url.bookmarks + '/create', data)
                    .then(response => {
                        self.bookmarks.data = null;
                        self.getBookmarks();
                        self.$root.modalHide(self.$root.options.modal.readerBookmark);
                        self.loading(event.target, false);
                        window.toastr.success('Закладка успешно добавлена', 'Успех', {
                            closeButton: true,
                            timeOut: 3000,
                        });
                    })
                    .catch();
            },

            /**
             * Прелоадер
             */
            loading(target, loading) {
                if (loading) {
                    target.classList.add('is-loading');
                } else {
                    target.classList.remove('is-loading');
                }
            },

            /**
             * Трансформер
             * 1 = #article01
             */
            articleIdToHref(id) {
                const self = this;
                return '#article' + self.formatNumberLength(id, 2);
            },

            /**
             * Трансформер
             * #article01 = 1
             */
            articleHrefToId(href) {
                let id = href.replace(/#article/g, '');
                return parseInt(id);
            },

            /**
             * Трансформер
             * 1 = 01
             */
            formatNumberLength(num, length) {
                let r = '' + num;
                while (r.length < length) {
                    r = '0' + r;
                }
                return r;
            }
        },
        /**
         * Вызывается при построении компонента
         */
        mounted() {
            const self = this;
            self.tabOnOpen();
            self.user = window.user;
            if (self.user.guest) {
                self.modalShowBootstrap(self.modal.login);
            }
            if (window.modal.active !== '') {
                self.modalShowBootstrap('#' + window.modal.active);
            } else {
                self.getRelease();
                self.intervalDeviceCheckOnline();
            }
        },
    }
</script>
<style lang="scss">
    #reader-panel {
        &.is-loading {
            overflow: hidden;
            &:before {
                content: '';
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #fff;
            }
        }
    }
    .v--modal {
        .modal-content {
            /*border-radius: 0;*/
            /*.action-block {*/
                /*.btn {*/
                    /*height: inherit;*/
                    /*background-color: transparent;*/
                    /*border-color: transparent;*/
                    /*color: #212529;*/
                /*}*/
            /*}*/
            /*.btn.focus, .btn:focus {*/
                /*box-shadow: none;*/
            /*}*/
        }
        .modal {
            padding-left: 0 !important;
        }
    }
</style>
