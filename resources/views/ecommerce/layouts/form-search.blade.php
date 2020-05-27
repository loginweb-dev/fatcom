<form name="form" id="form-search" action="{{ route('busqueda_ecommerce') }}" method="post">
    @csrf
    <input type="hidden" name="tipo_busqueda">
    <input type="hidden" name="subcategoria_id">
    <input type="hidden" name="marca_id">
    <input type="hidden" name="min">
    <input type="hidden" name="max">
    <input type="hidden" name="tipo_dato">
    <input type="hidden" name="dato">
    <input type="hidden" name="page">
    <input type="hidden" name="view_type">
</form>