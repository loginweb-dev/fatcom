function listenNewPedido(icon, user_id){
    Echo.channel(`deliveryChannel${user_id}`)
    .listen('pedidoAsignado', (e) => {
        Push.create("Nuevo pedido", {
            body: "Se le asignó un nuevo pedido.",
            icon: icon,
            timeout: 4000,
            onClick: function () {
                window.location='/admin/repartidor/delivery';
                this.close();
            }
        });

    });
}