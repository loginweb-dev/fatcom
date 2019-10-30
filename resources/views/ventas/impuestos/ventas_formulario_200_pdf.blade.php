<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ voyager_asset('images/icono.png') }}" type="image/x-icon">
    <title>Formulario 200</title>
    @php
        $color = '#012D57';
    @endphp
    <style>
        .r4{
            background-color:#FCA3A3
        }
        body{
            font-size: 13px;
            margin: 20px 100px;
            font-family: sans-serif;
        }
        .cabezera{
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            /* height: 300px; */
            padding: 10px;
            font-weight: bold;
            font-size: 17px
        }
        .celdaA{
            background-color: #ECEEF3;
        }
        .celdaB{
            background-color: #DADDE8;
        }
        .celdaC{
            background-color: #BAC0D3;
        }
        .cabezera1{
            height: 300px;
        }
        .cabezera2{
            height: 300px;
        }
        .cabezera3{
            height: 300px;
        }
        .cabezera4{
            height: 200px;
        }
        table{
            border: solid 4px {{$color}};
            width:100%
        }
        .btn-print{
            background-color: #fa2a00;
            color:white;
            border: 1px solid #fa2a00;
            padding: 5px 8px;
            border-radius:5px;
            z-index: 1000;
        }
        @media print{
            body{
                font-size: 10px;
                margin: 0px
            }
            .banner{
                margin-top:-20px
            }
            input{
                border: none;
                font-size: 10pt;
            }
            td {
                padding: 2px;
            }
            .cabezera{
                font-size: 10px
            }
            .cabezera1{
                height: 150px;
            }
            .cabezera2{
                height: 170px;
            }
            .cabezera3{
                height: 170px;
            }
            .cabezera4{
                height: 120px;
            }
            .btn-print{
                display: none;
            }
        }
    </style>
</head>
<body>
    @php setlocale(LC_ALL, 'es_ES'); @endphp
    <div style="text-align:right">
        <button onclick="javascript:window.print()" class="btn-print">Imprimir</button><br>
    </div>
    <img src="{{url('storage/banner/nlwRrwgMoxwO4CM7UJtcpXPITZapqxBGeFmZhGlo.png')}}" class="banner" width="100%" alt="">
    <table cellspacing="0" border="1px" cellpadding="8">
        <tr>
            <td rowspan="60" style="width:70px;background-color:{{$color}}"></td>
        </tr>
        <tr class="celdaA">
            <td colspan="12"><b>A) NOMBRE(S) Y APELLIDO(S) O RAZÓN SOCIAL DEL CONTRIBUYENTE : </b><br><br><span style="font-size:18px">{{setting('empresa.nombre')}}</span></td>
            <td colspan="2" style="text-align:center"><span style="text-align:center;font-size:9px"><b>NÚMERO DE ORDEN</b></span><h1>NN</h1></td>
        </tr>
        <tr class="celdaB">
            <td rowspan="3" colspan="7"><b>NIT : </b>{{setting('empresa.nit')}}</td>
        </tr>
        <tr class="celdaB">
            <td colspan="4"><b>PERIODO</b></td>
            <td colspan="2"><b>DD. JJ. ORIGINAL</b></td>
            <td><b>FOLIO</b></td>
        </tr>
        <tr class="celdaB">
            <td style="width:50px">MES</td>
            <td style="width:100px">{{strftime('%B', strtotime($anio.'-'.$mes.'-01'))}}</td>
            <td style="width:50px">AÑO</td>
            <td>{{$anio}}</td>
            <td>COD. 534</td>
            <td style="width:50px"></td>
            <td style="text-align:center;font-size:9px">USO ENTIDAD FINANCIERA O COLECTURÍA</td>
        </tr>
        <tr class="celdaA">
            <td colspan="14"><b>B) DATOS BÁSICOS DE LA DECLARACIÓN JURADA QUE RECTIFICA</b></td>
        </tr>
        <tr class="celdaB">
            <td>Cód. 518</td>
            <td colspan="5">NÚMERO DE RESOLUCIÓN ADMINISTRATIVA</td>
            <td>Cód. 537</td>
            <td colspan="2">FORMULARIO</td>
            <td>VERSIÓN</td>
            <td>Cód. 521</td>
            <td colspan="3" style="text-align:center">N&deg; DE ORDEN</td>
        </tr>
        <tr class="celdaA">
            <td colspan="11"><b>C) DETERMINACIÓN DEL SALDO DEFINITIVO A FAVOR DEL FISCO O DEL CONTRIBUYENTE</b></td>
            <td align="center"><small>Cód.<br>Casilla</small></td>
            <td colspan="2" align="center">IMPORTE<br><small>(EN BOLIVIANOS SIN CENTAVOS)</small></td>
        </tr>

        {{-- variables --}}
        @php
            $celda1 = intval($ventas->importe_venta-$ventas->tasa_cero);
            $celda2 = intval($ventas->importe_exento);
            $celda3 = intval($ventas->tasa_cero);
            $celda4 = 0;
            $celda5 = 0;
            $celda6 = 0;
            $celda7 = intval($compras->descuento);
            $celda8 = intval(($celda1+$celda5+$celda6+$celda7)*0.13);
            $celda9 = 0;
            $celda10 = $celda8+$celda9;

            $celda11 = $compras->importe_compra;
            $celda12 = $compras->importe_base;
            $celda13 = 0;
            $celda14 = 0;
            $celda15 = $ventas->descuento;
            $celda16 = intval(($celda12+$celda14+$celda15)*0.13);
            $celda17 = intval((($celda13*($celda1+$celda2))/($celda1+$celda2+$celda3+$celda4))*0.13);
            $celda18 = $celda16+$celda17;

            $celda19 = ($celda18-$celda10)>0 ? $celda18-$celda10 : 0;
            $celda20 = ($celda10-$celda18)>0 ? $celda10-$celda18 : 0;
            $celda21 = 0;
            $celda22 = 0;
            $celda23 = ($celda20-$celda21-$celda22)>0 ? $celda20-$celda21-$celda22 : 0;
            $celda24 = 0;
            $celda25 = 0;
            $celda26 = ($celda24-$celda25-$celda23)>0 ? $celda24-$celda25-$celda23 : 0;
            $celda27 = ($celda23-$celda24-$celda25)>0 ? $celda23-$celda24-$celda25 : 0;

            $celda28 = $celda27;
            $celda29 = 0;
            $celda30 = 0;
            $celda31 = 0;
            $celda32 = 0;
            $celda33 = ($celda28+$celda29+$celda30+$celda31+$celda32)>0 ? $celda28+$celda29+$celda30+$celda31+$celda32 : 0;

            $celda34 = ($celda19+$celda21+$celda22-$celda20)>0 ? $celda19+$celda21+$celda22-$celda20 : 0;
            $celda35 = ($celda26-$celda33)>0 ? $celda26-$celda33 : 0;
            $celda36 = ($celda33-$celda26)>0 ? $celda33-$celda26 : 0;

            $celda37 = 0;
            $celda38 = $celda36;

        @endphp
        <tr class="celdaA">
            <td rowspan="11"><div class="cabezera cabezera1">FISCAL <br> DETERMINACIÓN DEL DÉBITO <br> RUBRO 1:</div></td>
        </tr>
        <tr class="celdaA">
            <td style="width:40px">1</td>
            <td colspan="9">Ventas de bienes y/o servicios grabados en el mercado interno,excepto vantas grabadas con taza cero</td>
            <td>13</td>
            <td colspan="2" id="celda1">{{$celda1}}</td>
        </tr>
        <tr class="celdaB">
            <td>2</td>
            <td colspan="9">Exportacion de vienes y operaciones exentas</td>
            <td>14</td>
            <td colspan="2" id="celda2">{{$celda2}}</td>
        </tr>
        <tr class="celdaA">
            <td>3</td>
            <td colspan="9">Ventas grabadas a taza cero</td>
            <td>15</td>
            <td colspan="2" id="celda3">{{$celda3}}</td>
        </tr>
        <tr class="celdaB">
            <td>4</td>
            <td colspan="9">Ventas no grabadas y/o operaciones que no son objeto del IVA</td>
            <td>505</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda4}}" class="calculable celdaB" id="celda4"></td>
        </tr>
        <tr class="celdaA">
            <td>5</td>
            <td colspan="9">Valor atribuido a bienes y/o servicios retirados y consumo particulares</td>
            <td>16</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda5}}" class="calculable celdaA" id="celda5"></td>
        </tr>
        <tr class="celdaB">
            <td>6</td>
            <td colspan="9">Devolución y recisiones efectuado en el periodo</td>
            <td>17</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda6}}" class="calculable celdaB" id="celda6"></td>
        </tr>
        <tr class="celdaA">
            <td>7</td>
            <td colspan="9">Descuentos,bonificaciones y rebajos obtenidos en el periodo</td>
            <td>18</td>
            <td colspan="2" id="celda7">{{$celda7}}</td>
        </tr>
        <tr class="celdaB">
            <td>8</td>
            <td colspan="9">Debito fiscal actualizado correspondiente a:((C13+C16+-C17+C18)*13%)</td>
            <td>39</td>
            <td colspan="2" id="celda8">{{$celda8}}</td>
        </tr>
        <tr class="celdaA">
            <td>9</td>
            <td colspan="9">Debito fiscal actualizado correspondiente a reintegros</td>
            <td>55</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda9}}" class="calculable celdaA" id="celda9"></td>
        </tr>
        <tr class="celdaB">
            <td>10</td>
            <td colspan="9">Total Debito fiscal del periodo (C39+C55)</td>
            <td>1002</td>
            <td colspan="2" id="celda10">{{$celda10}}</td>
        </tr>
        <tr class="celdaC">
            <td rowspan="9" ><div class="cabezera cabezera2">FISCAL <br> DETERMINACIÓN DEL CRÉDITO<br> RUBRO 2: </div></td>
        </tr>
        <tr class="celdaA">
            <td>11</td>
            <td colspan="9">Total Compras correspondiente a actividades grabadas y/o no grabadas</td>
            <td>11</td>
            <td colspan="2" id="celda11">{{$celda11}}</td>
        </tr>
        <tr class="celdaB">
            <td>12</td>
            <td colspan="9">Compras directamente vinculadas a actividades grabadas</td>
            <td>26</td>
            <td colspan="2" id="celda12">{{$celda12}}</td>
        </tr>
        <tr class="celdaA">
            <td>13</td>
            <td colspan="9">Compras en las que no es posible discriminar su vinculacion con actividades gravadas y no gravadas</td>
            <td>31</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda13}}" class="calculable celdaA" id="celda13"></td>
        </tr>
        <tr class="celdaB">
            <td>14</td>
            <td colspan="9">Devolucion y recision recibidas en el periodo</td>
            <td>27</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda14}}" class="calculable celdaB" id="celda14"></td>
        </tr>
        <tr class="celdaA">
            <td>15</td>
            <td colspan="9">Descuentos,bonificaciones y rebajas otorgadas en el periodo</td>
            <td>28</td>
            <td colspan="2" id="celda15">{{$celda15}}</td>
        </tr>
        <tr class="celdaB">
            <td>16</td>
            <td colspan="9">Credito fiscal correspondiente a:((C26+C27+C28)*13%</td>
            <td>114</td>
            <td colspan="2" id="celda16">{{$celda16}}</td>
        </tr>
        <tr class="celdaA">
            <td>17</td>
            <td colspan="9">Credito Fiscal proporcional correspondiente a la actividad gravadas (C31*(C13+C14)/(C13+C14+C15+C505))*13%</td>
            <td>1003</td>
            <td colspan="2" id="celda17">{{$celda17}}</td>
        </tr>
        <tr class="celdaB">
            <td>18</td>
            <td colspan="9">Total Credito Fiscal del periodo (C114+C1003)</td>
            <td>1004</td>
            <td colspan="2" id="celda18">{{$celda18}}</td>
        </tr>
        <tr class="celdaA">
            <td rowspan="10" ><div class="cabezera cabezera3">DIFERENCIA <br> DETERMINACIÓN DE LA  <br> RUBRO 3:</div></td>
        </tr>
        <tr class="celdaA">
            <td>19</td>
            <td colspan="9">Diferencia a fovor del contribuyente (C1004-C1002;Si >0)</td>
            <td>693</td>
            <td colspan="2" id="celda19">{{$celda19}}</td>
        </tr>
        <tr class="celdaB">
            <td>20</td>
            <td colspan="9">Diferencia a favor del fisco o impuesto determinado (C1002-C1004;Si > 0)</td>
            <td>909</td>
            <td colspan="2" id="celda20">{{$celda20}}</td>
        </tr>
        <tr class="celdaA">
            <td>21</td>
            <td colspan="9">Saldo de credito fiscal de periodo anterior a compensar (C592 del form.200 del periodo anterior)</td>
            <td>635</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda21}}" class="calculable celdaA" id="celda21"></td>
        </tr>
        <tr class="celdaB">
            <td>22</td>
            <td colspan="9">Actualizacion de valor sobre el saldo de credito fiscal del periodo anterior</td>
            <td>648</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda22}}" class="calculable celdaB" id="celda22"></td>
        </tr>
        <tr class="celdaA">
            <td>23</td>
            <td colspan="9">Saldo de impuesto Determinado a favor del Fisco(C909-C635-648; > 0)</td>
            <td>1001</td>
            <td colspan="2" id="celda23">{{$celda23}}</td>
        </tr>
        <tr class="celdaB">
            <td>24</td>
            <td colspan="9">Pagos a cuenta realizados en DD.JJ. y/o Boleta de pago correspondiente al periodo que se declara</td>
            <td>622</td>
            <td colspan="2" id="celda24"><input type="number" min="0" step="0.1" value="{{$celda24}}" class="calculable celdaB" id="celda24"></td>
        </tr>
        <tr class="celdaA">
            <td>25</td>
            <td colspan="9">Saldo de pagos a cuenta del periodo anterior a compensar (C747 del form.200 del periodo anterior)</td>
            <td>640</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda25}}" class="calculable celdaA" id="celda25"></td>
        </tr>
        <tr class="celdaB">
            <td>26</td>
            <td colspan="9">Saldo por pagos a cuenta a favor del contribuyente (C622+C640-C1001;Si > 0)</td>
            <td>643</td>
            <td colspan="2" id="celda26">{{$celda26}}</td>
        </tr>
        <tr class="celdaA">
            <td>27</td>
            <td colspan="9">Saldo a favor del fisco (C1001-C622-C640;Si >0)</td>
            <td>996</td>
            <td colspan="2" id="celda27">{{$celda27}}</td>
        </tr>
        <tr class="celdaC">
            <td rowspan="7" ><div class="cabezera cabezera4"> DEUDA TRIBUTARIA <br> DETERMINACIÓN DE LA <br> RUBRO 4: </div></td>
        </tr>
        <tr class="celdaB">
            <td>28</td>
            <td colspan="9">Tributo omitido  ( C996 )</td>
            <td>924</td>
            <td colspan="2" id="celda28">{{$celda28}}</td>
        </tr>
        <tr class="celdaA">
            <td>29</td>
            <td colspan="9">Actualizacion del valor sobre tributo omitido</td>
            <td>925</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda29}}" class="calculable celdaA" id="celda29"></td>
        </tr>
        <tr class="celdaB">
            <td>30</td>
            <td colspan="9">Intereses sobre tributos omitidos actualizado</td>
            <td>938</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda30}}" class="calculable celdaB" id="celda30"></td>
        </tr>
        <tr class="celdaA">
            <td>31</td>
            <td colspan="9">Multa por incumplimiento al deber formal ( IDF ) por presentacion fuera de plazo</td>
            <td>954</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda31}}" class="calculable celdaA" id="celda31"></td>
        </tr>
        <tr class="celdaB">
            <td>32</td>
            <td colspan="9">Multa por IDF por incremento del impuesto determinado en DD.JJ rectificatoria presentada fuera de plazo</td>
            <td>967</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda32}}" class="calculable celdaB" id="celda32"></td>
        </tr>
        <tr class="celdaA">
            <td>33</td>
            <td colspan="9">Total deuda tributaria ( C924+C925+C938+C954+C967 )</td>
            <td>955</td>
            <td colspan="2" id="celda33">{{$celda33}}</td>
        </tr class="celdaB">
        <tr class="celdaA">
            <td rowspan="4" ><div class="cabezera" style="height:100px;font-size:15px"> DEFINITIVO <br> SALDO <br> RUBRO 5:</div></td>
        </tr>
        <tr class="celdaB">
            <td>34</td>
            <td colspan="9">Saldo definitivo credito fiscal a favor del contribuyente para el siguente periodo (C693+C635+C648-C909;Si > 0)</td>
            <td>592</td>
            <td colspan="2" id="celda34">{{$celda34}}</td>
        </tr>
        <tr class="celdaA">
            <td>35</td>
            <td colspan="9">Saldo definitivo pro pagos a cuenta a favor del contribuyente para el siguente periodo(C643-C955;S i> 0)</td>
            <td>747</td>
            <td colspan="2" id="celda35">{{$celda35}}</td>
        </tr>
        <tr class="celdaB">
            <td>36</td>
            <td colspan="9">Saldo definitivo a favor del fisco (C996 ó(C955-C643) según corresponda;Si > 0))</td>
            <td>646</td>
            <td colspan="2" id="celda36">{{$celda36}}</td>
        </tr>
        <tr class="celdaC">
            <td rowspan="3" > <div class="cabezera"  style="padding:0px 20px;font-size:10px;height:50px">IMPORTE DE PAGO<br>RUBRO 6:</div></td>
        </tr>
        <tr class="celdaA">
            <td>37</td>
            <td colspan="9">Pago en valor (sujeto a verificacion y confirmacion del SIN)</td>
            <td>677</td>
            <td colspan="2"><input type="number" min="0" step="0.1" value="{{$celda37}}" class="calculable celdaA" id="celda37"></td>
        </tr>
        <tr class="celdaB">
            <td>38</td>
            <td colspan="9">Pago en efectivo (C646-677; Si > 0)</td>
            <td>576</td>
            <td colspan="2" id="celda38">{{$celda38}}</td>
        </tr>
        <tr class="celdaA">
            <td rowspan="3" > <div class="cabezera"  style="padding:0px 20px;font-size:10px">INFORMATIVOS DATOS<br>RUBRO 7:</div></td>
        </tr>
        <tr class="celdaA">
            <td>39</td>
            <td colspan="9">Permuta en venta de bienes y/o servicios</td>
            <td>580</td>
            <td colspan="2">0</td>
        </tr>
        <tr class="celdaB">
            <td>40</td>
            <td colspan="9">Permuta en compra de bienes y/o servicios</td>
            <td>581</td>
            <td colspan="2" id="celda38">0</td>
        </tr>
        <tr class="celdaC">
            <td rowspan="3" > <div class="cabezera"  style="padding:0px;font-size:10px;height:50px">SIGMA DATOS PAGO<br>RUBRO 8:</div></td>
        </tr>
        <tr class="celdaA">
            <td>41</td>
            <td colspan="2">N° C-31:</td>
            <td colspan="2">Nº de pago:</td>
            <td colspan="2">Fecha confirmación de pago:</td>
            <td rowspan="2" colspan="3">Importe pagado vía SIGMA</td>
            <td rowspan="2">8883</td>
            <td rowspan="2" colspan="3"></td>
        </tr>
        <tr class="celdaB">
            <td>42</td>
            <td>8880</td>
            <td style="width:50px"></td>
            <td>8882</td>
            <td colspan="2"></td>
            <td>8881</td>
        </tr>
        <tr class="celdaA">
            <td rowspan="2" colspan="9" style="text-align:center">
                <p>JURO LA EXACTITUD DE LA PRESENTE DECLARACIÓN<br>Artículo N° 22 y Artículo N° 78 Parágrafo I de la Ley N° 2492 Código Tributario Boliviano</p>
                <br>
                <p>..............................................................................................................................<br>Firma del sujeto pasivo o tercero responsable</p>
            </td>
            <td colspan="5">Aclaración de Firma:</td>
        </tr>
        <tr class="celdaA">
            <td colspan="6">CI:</td>
        </tr>
    </table>
    <b>D) SELLO Y REFRENDO ENTIDAD FINANCIERA</b><br>
    <script type="text/javascript" src="{{ voyager_asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.calculable').change(function(){
                if($(this).val()!=''){
                    calcular();
                }else{
                    $(this).val('0')
                }

            });
            $('.calculable').keyup(function(){
                if($(this).val()!=''){
                    calcular();
                }else{
                    $(this).val('0')
                }
            });
        });
        function calcular(){
            let celda1 = parseFloat($('#celda1').text());
            let celda2 = parseFloat($('#celda2').text());
            let celda3 = parseFloat($('#celda3').text());
            let celda4 = parseFloat($('#celda4').val());
            let celda5 = parseFloat($('#celda5').val());
            let celda6 = parseFloat($('#celda6').val());
            let celda7 = parseFloat($('#celda7').text());
            let celda8 = (celda1 + celda5 + celda6 + celda7) * 0.13;
            $('#celda8').text(celda8.toFixed(0));
            let celda9 = parseFloat($('#celda9').val());
            let celda10 = celda8 + celda9;
            $('#celda10').text(celda10.toFixed(0));
            let celda11 = parseFloat($('#celda11').text());
            let celda12 = parseFloat($('#celda12').text());
            let celda13 = parseFloat($('#celda13').val());
            let celda14 = parseFloat($('#celda14').val());
            let celda15 = parseFloat($('#celda15').text());
            let celda16 = (celda12 + celda14 + celda15) * 0.13;
            $('#celda16').text(celda16.toFixed(0));
            let celda17 = celda13 * (celda1 + celda2) / (celda1 + celda2 + celda3 + celda4) * 0.13;
            $('#celda17').text(celda17.toFixed(0));
            let celda18 = celda16 + celda17;
            $('#celda18').text(celda18.toFixed(0));
            let celda19 = (celda18 - celda10)>0 ? celda18 - celda10 : 0;
            $('#celda19').text(celda19.toFixed(0));
            let celda20 = (celda10 - celda18)>0 ? celda10 - celda18 : 0;
            $('#celda20').text(celda20.toFixed(0));
            let celda21 = parseFloat($('#celda21').val());
            let celda22 = parseFloat($('#celda22').val());
            let celda23 = (celda20 - celda21 - celda22)>0 ? celda20 - celda21 - celda22 : 0;
            $('#celda23').text(celda23.toFixed(0));
            let celda24 = parseFloat($('#celda24').val());
            let celda25 = parseFloat($('#celda25').val());
            let celda26 = (celda24 + celda25 - celda23)>0 ? celda24 + celda25 - celda23 : 0;
            $('#celda26').text(celda26.toFixed(0));
            let celda27 = (celda23 + celda24 - celda25)>0 ? celda23 + celda24 - celda25 : 0;
            $('#celda27').text(celda27.toFixed(0));
            let celda28 = celda27;
            $('#celda28').text(celda28.toFixed(0));
            let celda29 = parseFloat($('#celda29').val());
            let celda30 = parseFloat($('#celda30').val());
            let celda31 = parseFloat($('#celda31').val());
            let celda32 = parseFloat($('#celda32').val());
            let celda33 = (celda28 + celda29 + celda30 + celda31 + celda32)>0 ? celda28 + celda29 + celda30 + celda31 + celda32 : 0;
            $('#celda33').text(celda33.toFixed(0));
            let celda34 = (celda19 + celda21 + celda22 - celda20)>0 ? celda19 + celda21 + celda22 - celda20 : 0;
            $('#celda34').text(celda34.toFixed(0));
            let celda35 = (celda26 - celda33)>0 ? celda26 - celda33 : 0;
            $('#celda35').text(celda35.toFixed(0));
            let celda36 = (celda33 - celda26)>0 ? celda33 - celda26 : 0;
            $('#celda36').text(celda36.toFixed(0));
            let celda38 = celda36;
            $('#celda38').text(celda38.toFixed(0));

        }
    </script>
</body>
</html>
