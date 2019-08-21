<input type="hidden" name="compra_producto" value="">
<button type="button" class="btn btn-success btn-sm pull-right" onclick="agregarTr()">Agregar item <span class="voyager-plus"></span></button>
<div class="clearfix"></div><br>
<div class="table-responsive">
    <table class="table table-bordered" >
        <thead style="background-color:#F8FAFC">
            <td style="width:90px" class="">Cantidad</td>
            <td >Detalle</td>
            <td style="width:150px;">Precio</td>
            <td style="width:150px;">Subtotal</td>
            <td width="50px"></td>
        </thead>
        <tr id="tr-1">
            <td class=""><input type="number" data-indice="1" class="form-control" onchange="calcular_subtotal(1)" onkeyup="calcular_subtotal(1)" id="cantidad-1" min="1" step="1" value="1" name="cantidad[]" required></td>
            <td>
                <input type="text" class="form-control" name="producto[]" required>
            </td>
            <td><input type="number" data-indice="1" class="form-control" onchange="calcular_subtotal(1)" onkeyup="calcular_subtotal(1)" id="precio-1" value="0.00" step="0.1" style="width:150px;" name="precio[]" required></td>
            <td><b class="label-subtotal" id="label-subtotal-1" style="width:150px;">0.00</b></td>
            <td>
                <button type="button" class="btn btn-danger"><span class="voyager-trash"></span></button>
            </td>
        </tr>
        <tr id="tr-total">
            <td colspan="3" class="text-right"><b>TOTAL</b></td>
            <td colspan="2"><b id="label-total">0.00 Bs.</b></td>
        </tr>
    </table>
</div>
{{-- <script type="text/javascript" src="{{ voyager_asset('js/app.js') }}"></script> --}}
<script src="{{url('js/compras.js')}}"></script>
<script>
        $(document).ready(function(){
        });

        // agregar fila
        // variable de numero de filas
        var cont = 2;
        function agregarTr(){
            $('#tr-total').before(`<tr id="tr-${cont}" class="tr-detalle">
                                    <td class=""><input type="number" data-indice="${cont}" class="form-control" onchange="calcular_subtotal(${cont})" onkeyup="calcular_subtotal(${cont})" id="cantidad-${cont}" min="1" step="1" value="1" name="cantidad[]"></td>
                                    <td><input type="text" class="form-control" name="producto[]"></td>
                                    <td><input type="number" data-indice="${cont}" class="form-control" onchange="calcular_subtotal(${cont})" onkeyup="calcular_subtotal(${cont})" id="precio-${cont}" value="0.00" step="0.1" name="precio[]" ></td>
                                    <td><b class="label-subtotal" id="label-subtotal-${cont}">0.00</b></td>
                                    <td>
                                        <button type="button" onclick="borrarTr(${cont})" class="btn btn-danger"><span class="voyager-trash"></span></button>
                                    </td>
                                </tr>`);
            cont++;
        }

    </script>
