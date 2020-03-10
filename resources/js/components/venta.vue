<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <!-- <th>N&deg; venta</th> -->
                                    <th>N&deg; ticket</th>
                                    <th>Tipo</th>
                                    <!-- <th>Total</th> -->
                                    <!-- <th>Estado</th> -->
                                    <th>Hora de <br> Pedido</th>
                                    <th>Hora de <br> entregar</th>
                                    <th>Detalles</th>    
                                    <th class="actions text-right" style="width:100px">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="venta in ventas" :key="venta.id">
                                    <!-- <td>{{venta.id}}</td> -->
                                    <td>{{ venta.nro_venta }}</td>
                                    <td>{{ venta.tipo_venta }}</td>
                                    <!-- <td>{{venta.importe}}</td> -->
                                    <!-- <td>{{venta.estado_venta}}</td> -->
                                    <td>{{ new Date(venta.created_at).getHours()}}:{{ new Date(venta.created_at).getMinutes()}}</td>
                                    <td>{{ new Date(venta.hora_entrega).getHours()}}:{{ new Date(venta.hora_entrega).getMinutes()}}</td>
                                    <td>
                                        <ul id="example-1" style="list-style:none;font-size:16px">
                                            <li v-for="item in venta.items" :key="item.id">
                                                {{ parseInt(item.cantidad) }} {{ item.producto.nombre }} {{ item.productoadicional ? `- ${item.productoadicional.nombre}` : '' }} {{ item.producto.subcategoria.nombre }}
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                      <button title="Listo" @click="entregar(venta)"  class="btn btn-view btn-success">
                                        <i class="voyager-check"></i> <span class="hidden-xs hidden-sm">Listo</span>
                                     </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
          ventas:[],
          preparacion: '',
          convertir: ''
        }
    },
    mounted() {
         this.fetchventas()
    },
    methods: {
       fetchventas () {
            setInterval(() => {
              axios.get('/admin/ventas/cocina/list')
                .then(response => {
                    this.ventas = response.data;
                    console.log(response.data);
                });
            }, 5000)
        },
        entregar (venta) {
        axios.post('/admin/ventas/entregar/'+venta.id)
           .then(response=>{
             if (response.status == 200) {
                 toastr.info(response.data.saved);
                 this.fetchventas()
             }            
           }).catch(e =>{
               console.log(e)
           })
      }
    },
   
}
</script>