<div class="container" id="send_article">
    <form id="sendArticle" action="{{ route('send.article') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="journal" value="{{ $journal->id }}">
        <div class="row justify-content-around">
            <div class="col-xl-8 col-lg-8 col-12 order-3 order-xl-2 order-lg-2">

                @include('magazines.detail.breadcrumbs', compact('journal'))

                <div class="row issue-main">
                    <div class="col-xl-4 col-lg-4 col-md-3 col-sm-4 col-12">
                        <div class="issue-cover">
                            <img src="{{ $journal->image }}">
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-9 col-sm-8 col-12">
                        <h3>Прислать статью</h3>
                        <div class="subscribe-form">

                            <div class="subscribe-fields">
                                <div class="form-margin">
                                    <label>Ваше имя</label>
                                    <input type="text" placeholder="" name="name" required="required">
                                </div>
                                <div class="form-margin">
                                    <label>Ваш email</label>
                                    <input type="email" placeholder="" name="email" required="required">
                                </div>
                                <div>
                                    <label>Сообщение</label>
                                    <textarea type="text" placeholder="" name="message" required="required"></textarea>
                                </div>
                                <div>
                                    <label>Прикрепить файл</label>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
											<span class="btn-file action-item">
												<span class="fileupload-new">Выберите файл</span>
												<span class="fileupload-exists">Выбрать другой</span>
												<input type="file" name="files">
											</span>
                                        <div class="file-preview">
                                            <span class="fileupload-preview"></span>
                                            <div class="fileupload-close">
                                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-gutters justify-content-end">
                                    <div class="clear-button"><button type="reset"><span>очистить</span></button></div>
                                    <div><button type="submit" class=""><span>отправить</span></button></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-12 order-2 order-xl-3 order-lg-3">
                @include('includes.sidebar', ['hide' => ['title']])
            </div>
        </div>
    </form>
</div>
<script>
//    $('form#sendArticle').on('submit', MagazineDetailManager.sendArticle);
</script>
