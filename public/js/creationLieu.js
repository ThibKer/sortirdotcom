// Get the modal
modal = document.getElementById("myModal");

// Get the button that opens the modal
btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
span = document.getElementsByClassName("close")[0];

validation = document.getElementById("creer-lieu");

validation.onclick = function () {
    modal.style.display = 'none';
    createLieu();
}

// When the user clicks the button, open the modal
btn.onclick = function () {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function createLieu(){
    for(i = 0; i < document.getElementById('lieu_ville').length; i++){
        if(document.getElementById('lieu_ville')[i].value == document.getElementById('lieu_ville').value){
            nomVille = document.getElementById('lieu_ville')[i].innerText;
        }
    }
    newLieu = {
        "id" : "new",
        "nom" : document.getElementById('lieu_nom').value,
        "rue" : document.getElementById('lieu_rue').value,
        "latitude" : document.getElementById('lieu_latitude').value,
        "longitude" : document.getElementById('lieu_longitude').value,
        "ville" : {
            "id" : document.getElementById('lieu_ville').value,
            "nom" : nomVille,
            "codePostal" : null,
            "lieux" : [],
            "__initializer__":null,
            "__cloner__":null,
            "__isInitialized__":true
        },
    }
    valueHidden = JSON.parse(document.getElementById("hidden").value);
    valueHidden.push(newLieu);
    document.getElementById("hidden").value = JSON.stringify(valueHidden);
}