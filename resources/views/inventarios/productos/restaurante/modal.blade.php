{{-- Modal agregar insumo --}}
<div class="modal fade" id="modal_insumos" tabindex="-1" role="dialog" aria-labelledby="smallModal" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lista de insumos</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <select id="select-insumo_id" class="form-control select2">
                        @foreach($insumos as $item)
                        <option data-unidad="{{$item->unidad}}" value="{{$item->id}}" >{{$item->nombre}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" id="btn-add" style="margin-top:0px;padding:8px" type="button"><span class="voyager-plus" aria-hidden="true"></span> Agregar</button>
                    </span>
                </div>
                <br>
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr>
                            <th>Insumo</th>
                            <th>Cantidad</th>
                            <th>Unid.</th>
                            <th></th>
                        </tr>
                        <tbody id="lista-insumos">
                            @isset($insumos_productos)
                                @php
                                    $cont_insumos = 1;
                                @endphp
                                @foreach ($insumos_productos as $item)
                                <tr id="tr-{{$cont_insumos}}">
                                    <td>{{$item->nombre}}</td>
                                    <td>
                                        <input type="hidden" name="insumo_id[]" class="input-insumo" value="{{$item->id}}">
                                        <input type="number" class="form-control" name="cantidad_insumo[]" value="{{$item->cantidad}}" min="0.1" step="0.1" required>
                                    </td>
                                    <td>{{$item->unidad}}</td>
                                    <td><span class="voyager-x text-danger" onclick="borrarTr({{$cont_insumos}})"></span></td>
                                </tr>
                                @php
                                    $cont_insumos++;
                                @endphp
                            @endforeach
                            @endisset
                        </tbody>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-validadInsumos">Aceptar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal agregar extra --}}
<div class="modal fade" id="modal_extras" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lista de extras</h4>
            </div>
            <div class="modal-body" style="max-height:400px;overflow-y:auto">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Precio</th>
                        </tr>
                        <tbody>
                            @foreach($extras as $item)
                                @php
                                    $checked = false;
                                @endphp
                                @isset($productos_extras)
                                    @php
                                        foreach($productos_extras as $p_e){
                                            if($p_e->extra_id == $item->id){
                                                $checked = true;
                                            }
                                        }
                                    @endphp
                                @endisset
                                <tr>
                                    <td style="width:50px;text-align:center">
                                        <input type="checkbox" @if ($checked) checked @endif name="extra_id[]" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->precio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>