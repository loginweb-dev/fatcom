<form id="form-rating" action="{{ route('productos_puntuar') }}" method="post">
    @csrf
    <input type="hidden" name="ajax" value="1">
    <input type="hidden" name="id" value="{{ $id }}">
    <input type="hidden" name="puntos" id="input-puntos" value="">
</form>