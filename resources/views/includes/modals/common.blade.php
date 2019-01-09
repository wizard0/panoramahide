@component('components.modal', ['id' => 'code-modal', 'title' => 'Введите код подтверждения'])
    @slot('body')
        <form action="{{ route('promo.code') }}" class="ajax-form">
            <div class="form-group">
                <label>Код подтверждения</label>
                <input type="text" name="name" value="" required>
            </div>
            <div class="form-group m-0 text-right">
                <button type="submit" class="btn inner-form-submit">
                    <span>Зарегистрироваться</span>
                </button>
            </div>
        </form>
    @endslot
@endcomponent
