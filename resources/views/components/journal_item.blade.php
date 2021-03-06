<div class="magazine-item entity-item d-flex col-12 _magazine"
     data-id="{{ $id }}"
     data-link="{{ route('journal', compact('code')) }}"
     data-link-subscribe="/magazines/##.html#subscribe">
    <div class="checkbox-col">
        <input id="magazine-index-{{ $id }}" type="checkbox" name="article-choise" data-type="journal" value="{{ $id }}" />
        <label for="magazine-index-{{ $id }}"></label>
    </div>
    <div class="article-info-col">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2 col-12">
                <div class="issue-image">
                    <a href="{{ route('journal', compact('code')) }}">
                        <img src="{{ $image }}">
                    </a>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-10 col-12">
                <h3><a href="{{ route('journal', compact('code')) }}" class="black-link itemName">{{ $name }}</a></h3>
                <div class="announce">
                    <p></p>
                </div>
            </div>
        </div>
        <div class="magazine-footer row justify-content-between align-items-center no-gutters">
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-3 col-12 out-issn">
                <span>ISSN:</span>{{ $issn }}							</div>
            <div class="d-flex col-xl-8 col-lg-8 col-md-4 col-sm-6 col-12 goto-issue justify-content-xl-center justify-content-lg-center justify-content-md-center justify-content-sm-center justify-content-start">
                <span>к номеру:</span>
                <select name="number">
                    @foreach ($releases as $release)
                        <option value="{{ route('release', ['journalCode' => $code, 'releaseID' => $release->id]) }}">№ {{ $release->number }}, {{ $release->year }}</option>
                    @endforeach
                </select>
                <a href="" class="_go_to_number_{{ $id }}">перейти</a>
            </div>
            <div class="d-flex col-xl-2 col-lg-2 col-md-4 col-sm-3 col-12 get-access-red justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-sm-end justify-content-start">
                <a href="{{ route('journal', compact('code')) }}#subscribe" class="red-link">получить доступ</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $(document).on('click', '._go_to_number_{{ $id }}', function(){
            var link = $(this).parents('.magazine-item').find('[name=number]').val();
            location.href = link;
            return false;
        });
    });
</script>
