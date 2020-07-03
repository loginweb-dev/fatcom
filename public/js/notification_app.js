function sendNotificationApp(url, FCMToken, tokenDevice, notification){
    var data = {
        to: tokenDevice,
        content_available: true,
        notification: {
            title: notification.title,
            body: notification.message,
            sound: "default",
            fcmMessageType: "notifType",
            priority: "high",
            show_in_foreground: true
        }
    };

    fetch(url, {
    method: 'POST',
    body: JSON.stringify(data),
    headers:{
        'Content-Type': 'application/json',
        'Authorization': `key=${FCMToken}`
    }
    }).catch(error => console.error('Error en notificación movil:', error))
}