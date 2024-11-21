var values_from_card = document.getElementById('values-from-card');

setInterval(function() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php/fetch-data.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                values_from_card.innerHTML = data;
            }
        }
    }
    xhr.send();
}, 500);
