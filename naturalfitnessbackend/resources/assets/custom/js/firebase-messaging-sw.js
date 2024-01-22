//importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
//importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyALVIvWgN8NauJnGzj6vPk_YrUb5Ox2vP4",
    projectId: "daride-687d9",
    messagingSenderId: "570343363974",
    appId: "1:570343363974:web:bae909afa1d1f70ae70807"
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});