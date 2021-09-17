function getMap(long, lat) {
    return new Promise((resolve, reject) => {
            img = document.createElement('img');
            img.setAttribute('src', 'https://image.maps.ls.hereapi.com/mia/1.6/mapview?c=' + lat + '%2C' + long + '&t=3&apiKey=7eOu-tOEBVXMyZV9ROfmZHLNJjeitBLmciQtqGN6it0');
            document.getElementById('map').appendChild(img);
    });
}