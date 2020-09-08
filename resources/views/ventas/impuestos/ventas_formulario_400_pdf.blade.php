<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ voyager_asset('images/icono.png') }}" type="image/x-icon">
    <title>Formulario 400</title>
    @php
        $color = '#CC1F1D';
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
            background-color: #FCF3EE;
        }
        .celdaB{
            background-color: #FAE8DF;
        }
        .celdaC{
            background-color: #F6D2C2;
        }
        .cabezera1{
            height: 150px;
            font-size: 12px
        }
        .cabezera2{
            height: 200px;
            font-size: 12px
        }
        .cabezera3{
            height: 200px;
            font-size: 12px
        }
        .cabezera4{
            height: 100px;
            font-size: 12px
        }
        .cabezera5{
            height: 50px;
            font-size: 10px
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
                border: none
            }
            td {
                padding: 2px;
            }
            .cabezera{
                font-size: 10px
            }
            .cabezera1{
                height: 80px;
            }
            .cabezera2{
                height: 100px;
            }
            .cabezera3{
                height: 170px;
            }
            .cabezera4{
                height: 60px;
            }
            .cabezera5{
                height: 50px;
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
    <img src="{{url('storage/banner/JuVRFTWBMmdHsEnmAsbyNL7sl1KJfGHt4lKNVKh5.png')}}" class="banner" width="100%" alt="">
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
            <td colspan="3" style="text-align:center"&deg; DE ORDEN</td>
        </tr>
        <tr class="celdaA">
            <td colspan="11"><b>C) DETERMINACIÓN DEL SALDO DEFINITIVO A FAVOR DEL FISCO O DEL CONTRIBUYENTE</b></td>
            <td align="center"><small>Cód.<br>Casilla</small></td>
            <td colspan="2" align="center">IMPORTE<br><small>(EN BOLIVIANOS SIN CENTAVOS)</small></td>
        </tr>

        {{-- variables --}}
        @php
            $celda1 = intval($ventas->importe_venta);
            $celda2 = intval($ventas->importe_exento);
            $celda3 = intval($celda1 - $celda2);
            $celda4 = intval($celda3 * 0.03);

            $celda5 = 0;
            $celda6 = ($celda4-$celda5)>0 ? $celda4-$celda5 : 0;
            $celda7 = 0;
            $celda8 = 0;
            $celda9 = ($celda7 + $celda8 - $celda6)>0 ? $celda7 + $celda8 - $celda6 : 0;
            $celda10 = ($celda6 - $celda7 - $celda8)>0 ? $celda6 - $celda7 - $celda8 : 0;

            $celda11 = $celda10;
            $celda12 = 0;
            $celda13 = 0;
            $celda14 = 0;
            $celda15 = 0;
            $celda16 = $celda11 + $celda12 + $celda13 + $celda14 + $celda15;

            $celda17 = ($celda5 - $celda4)>0 ? $celda5 - $celda4 : 0;
            $celda18 = ($celda9 - $celda10)>0 ? $celda9 - $celda10 : 0;
            $celda19 = ($celda16 - $celda9)>0 ? $celda16 - $celda9 : 0;

            $celda20 = 0;
            $celda21 = $celda19;

        @endphp
        <tr class="celdaA">
            <td rowspan="5"><div class="cabezera cabezera1" style="">IMPUESTOS<br>BASE IMPONIBLE E<br>DETERMINACION DE LA<br>RUBRO 1:</div></td>
        </tr>
        <tr class="celdaA">
            <td style="width:40px">1</td>
            <td colspan="9">Total Igresos Brutos Devengados y/o recividos en especie (incluye ingresos exentos)</td>
            <td>13</td>
            <td colspan="2" id="celda1">{{$celda1}}</td>
        </tr>
        <tr class="celdaB">
            <td>2</td>
            <td colspan="9">Ingresos exentos</td>
            <td>32</td>
            <td colspan="2" id="celda2">{{$celda2}}</td>
        </tr>
        <tr class="celdaA">
            <td>3</td>
            <td colspan="9">Base Imponible (C13-C32)</td>
            <td>24</td>
            <td colspan="2" id="celda3">{{$celda3}}</td>
        </tr>
        <tr class="celdaB">
            <td>4</td>
            <td colspan="9">Impuesto Determinado (C24*3%)</td>
            <td>909</td>
            <td colspan="2" id="celda4">{{$celda4}}</td>
        </tr>
        <tr class="celdaC">
            <td rowspan="7" ><div class="cabezera cabezera2">DETERMINACION DE SALDO<br>RUBRO 2:</div></td>
        </tr>
        <tr class="celdaA">
            <td>5</td>
            <td colspan="9">IUE pagado a compensar (1ra. Instancia o  saldo IUE a compensar del form. 400, C619 del periodo anterior)</td>
            <td>664</td>
            <td colspan="2"><input type="number" min="0" step="0.01" value="{{$celda5}}" class="calculable celdaA" id="celda5"></td>
        </tr>
        <tr class="celdaB">
            <td>6</td>
            <td colspan="9">Saldo del impuesto determinado a favor del fisco ( C909-C664; Si > 0 )</td>
            <td>1001</td>
            <td colspan="2" id="celda6">{{$celda6}}</td>
        </tr>
        <tr class="celdaA">
            <td>7</td>
            <td colspan="9">Pagos a cuenta realizados en DD.JJ. y/o boleta de pago correspondientes al periodo que se declare</td>
            <td>622</td>
            <td colspan="2"><input type="number" min="0" step="0.01" value="{{$celda7}}" class="calculable celdaB" id="celda7"></td>
        </tr>
        <tr class="celdaB">
            <td>8</td>
            <td colspan="9">Saldo de pago a cuenta del periodo anterior a compensar (C747 del form. 400 del periodo anterior)</td>
            <td>640</td>
            <td colspan="2"><input type="number" min="0" step="0.01" value="{{$celda8}}" class="calculable celdaA" id="celda8"></td>
        </tr>
        <tr class="celdaA">
            <td>9</td>
            <td colspan="9">Saldo por pago a cuenta a favor del contribuyente ( C622+C640-C1001; Si>0 )</td>
            <td>643</td>
            <td colspan="2" id="celda9">{{$celda9}}</td>
        </tr>
        <tr class="celdaB">
            <td>10</td>
            <td colspan="9">Saldo a favor del fisco ( C1001-C622-C640; Si > 0 )</td>
            <td>996</td>
            <td colspan="2" id="celda10">{{$celda10}}</td>
        </tr>
        <tr class="celdaA">
            <td rowspan="7" ><div class="cabezera cabezera3">TRIBUTARIA<br>DETERMINACION DE LA DEUDA<br>RUBRO 3:</div></td>
        </tr>
        <tr class="celdaA">
            <td>11</td>
            <td colspan="9">Tributo omitido  ( C996 )</td>
            <td>924</td>
            <td colspan="2" id="celda11">{{$celda11}}</td>
        </tr>
        <tr class="celdaB">
            <td>12</td>
            <td colspan="9">Actualizacion del valor sobre tributo omitido</td>
            <td>925</td>
            <td colspan="2"><input type="number" min="0" step="0.01" value="{{$celda12}}" class="calculable celdaB" id="celda12"></td>
        </tr>
        <tr class="celdaA">
            <td>13</td>
            <td colspan="9">Intereses sobre tributos omitidos actualizado</td>
            <td>938</td>
            <td colspan="2"><input type="number" min="0" step="0.01" value="{{$celda13}}" class="calculable celdaA" id="celda13"></td>
        </tr>
        <tr class="celdaB">
            <td>14</td>
            <td colspan="9">Multa por incumplimiento al deber formal ( IDF ) por presentacion fuera de plazo</td>
            <td>954</td>
            <td colspan="2"><input type="number" min="0" step="0.01" value="{{$celda14}}" class="calculable celdaB" id="celda14"></td>
        </tr>
        <tr class="celdaA">
            <td>15</td>
            <td colspan="9">Multa por IDF por incremento del impuesto determinado en DD.JJ rectificatoria presentada fuera de plazo</td>
            <td>967</td>
            <td colspan="2"><input type="number" min="0" step="0.01" value="{{$celda15}}" class="calculable celdaA" id="celda15"></td>
        </tr>
        <tr class="celdaB">
            <td>16</td>
            <td colspan="9">Total deuda tributaria ( C924+C925+C938+C954+C967 )</td>
            <td>955</td>
            <td colspan="2" id="celda16">{{$celda16}}</td>
        </tr>
        <tr class="celdaC">
            <td rowspan="4" ><div class="cabezera cabezera4">DEFINITIVO<br>SALDO<br>RUBRO 4:</div></td>
        </tr>
        <tr class="celdaA">
            <td>17</td>
            <td colspan="9">Saldo definitivo de IUE a compensar para el siguiente periodo ( C664-C909; Si > 0 )</td>
            <td>619</td>
            <td colspan="2" id="celda17">{{$celda17}}</td>
        </tr>
        <tr class="celdaB">
            <td>18</td>
            <td colspan="9">Saldo definitivo pro pagos a cuenta a favor del contribuyente para el siguente periodo(C643-C955;S i> 0)</td>
            <td>747</td>
            <td colspan="2" id="celda18">{{$celda18}}</td>
        </tr>
        <tr class="celdaA">
            <td>19</td>
            <td colspan="9">Saldo definitivo a favor del fisco (C996 ó(C955-C643) según corresponda;Si > 0))</td>
            <td>646</td>
            <td colspan="2" id="celda19">{{$celda19}}</td>
        </tr>
        <tr class="celdaC">
            <td rowspan="3" ><div class="cabezera cabezera5">DE PAGO<br>IMPORTE<br>RUBRO 5:</div></td>
        </tr>
        <tr class="celdaB">
            <td>20</td>
            <td colspan="9">Pagos en valores ( sujeto a verificacion y confirmacion por el SIN )</td>
            <td>677</td>
            <td colspan="2"><input type="number" min="0" step="0.01" value="{{$celda20}}" class="calculable celdaB" id="celda20"></td>
        </tr>
        <tr class="celdaA">
            <td>21</td>
            <td colspan="9">Pago en efectivo (C646-677; Si > 0)</td>
            <td>576</td>
            <td colspan="2" id="celda21">{{$celda21}}</td>
        </tr>
        <tr class="celdaC">
            <td rowspan="3" > <div class="cabezera"  style="padding:0px;font-size:10px;height:50px">SIGMA DATOS PAGO<br>RUBRO 6:</div></td>
        </tr>
        <tr class="celdaA">
            <td>22</td>
            <td colspan="2">N° C-31:</td>
            <td colspan="3">Nº de pago:</td>
            <td colspan="2">Fecha confirmación de pago:</td>
            <td rowspan="2" colspan="2">Importe pagado vía SIGMA</td>
            <td rowspan="2">8883</td>
            <td rowspan="2" colspan="3"></td>
        </tr>
        <tr class="celdaB">
            <td>23</td>
            <td>8880</td>
            <td style="width:50px"></td>
            <td>8882</td>
            <td colspan="2"></td>
            <td>8881</td>
            <td></td>
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
            <td colspan="5">CI:</td>
        </tr>
    </table>
    <b>D) SELLO Y REFRENDO ENTIDAD FINANCIERA</b>
    <br>
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
            let celda4 = parseFloat($('#celda4').text());

            let celda5 = parseFloat($('#celda5').val());
            let celda6 = celda4 - celda5;
            $('#celda6').text(celda6.toFixed(0));
            let celda7 = parseFloat($('#celda7').val());
            let celda8 = parseFloat($('#celda8').val());
            let celda9 = (celda7 + celda8 - celda6)>0 ? celda7 + celda8 - celda6 : 0;
            $('#celda9').text(celda9.toFixed(0));
            let celda10 = (celda6 - celda7 - celda8)>0 ? celda6 - celda7 - celda8 : 0;
            $('#celda10').text(celda10.toFixed(0));

            let celda11 = celda10;
            let celda12 = parseFloat($('#celda12').val());
            let celda13 = parseFloat($('#celda13').val());
            let celda14 = parseFloat($('#celda14').val());
            let celda15 = parseFloat($('#celda15').val());
            let celda16 = celda11 + celda12 + celda13 + celda14 + celda15;
            $('#celda16').text(celda16.toFixed(0));

            let celda17 = (celda5 - celda4)>0 ? celda5 - celda4 : 0;
            $('#celda17').text(celda17.toFixed(0));
            let celda18 = (celda9 - celda10)>0 ? celda9 - celda10 : 0;
            $('#celda18').text(celda18.toFixed(0));
            let celda19 = (celda16 - celda9)>0 ? celda16 - celda9 : 0;
            $('#celda19').text(celda19.toFixed(0));

            let celda20 = parseFloat($('#celda20').val());
            let celda21 = celda9;
        }
    </script>
</body>
</html>
