<script language="JavaScript">
    window.open('{{ route('personal.order.payment', $order->id) }}');
</script>
Если окно с платежной информацией не открылось автоматически, нажмите на ссылку <a class="btn btn-default" href="{{ route('personal.order.payment', $order->id) }}" target="_blank">Оплатить заказ</a>.
