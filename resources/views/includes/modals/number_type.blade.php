@component('components.modal', ['id' => 'number-type', 'title' => 'Выберите тип'])
    @slot('body')
        <form>
            <input type="hidden" name="id" value="">
            <div class="form-group d-flex justify-content-center">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary">
                        <input type="radio" name="version" value="{{ Cart::VERSION_PRINTED }}" autocomplete="off"> Печатный								</label>
                    <label class="btn btn-outline-secondary">
                        <input type="radio" name="version" value="{{ Cart::VERSION_ELECTRONIC }}" autocomplete="off"> Электронный								</label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn basic-button">Выбрать</button>
            </div>
        </form>
    @endslot
@endcomponent
