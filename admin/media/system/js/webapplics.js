var online = window.navigator.onLine;
if (!online) {
    alert("Application is offline...");
}


/*let preloadVideo = true;
var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
if (connection) {
  if (connection.type === 'cellular') {
    preloadVideo = false;
  }
}

To see changes in the network state, use addEventListener to listen for the events on window.ononline and window.onoffline, as in the following example:

window.addEventListener('offline', function(e) { console.log('offline'); });

window.addEventListener('online', function(e) { console.log('online'); });

*/