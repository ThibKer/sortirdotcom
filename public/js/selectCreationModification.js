window.onload = function() {
    changementLieu();
    changementInfoLieu();
};
document.getElementById('select-creation').addEventListener("change", changementInfoLieu);
document.getElementById('select-ville').addEventListener("change", changementLieu);

function changementLieu(){
    selectVille = document.getElementById('select-ville-balise');
    choix = selectVille.value;
    lieuxObj = JSON.parse(document.getElementById('hidden').value);

    selectLieu = document.getElementById('select-creation').getElementsByTagName("select")[0];
    selectLieu.innerHTML = "";

    for (i = 0; i < lieuxObj.length; i++){
        if(lieuxObj[i].ville.id == choix){
            element = document.createElement('option');
            element.value = lieuxObj[i].id;
            element.innerText = lieuxObj[i].nom;
            selectLieu.appendChild(element);
        }
    }

    changementInfoLieu();
}

function changementInfoLieu(){
    select = document.getElementById('select-creation').getElementsByTagName("select");
    for(i = 0; i < select.length; i++){
        choix = select[i].value;
    }
    lieux = document.getElementById('hidden').value;
    lieuxObj = JSON.parse(lieux);
    trouver = false;
    for (i = 0; i < lieuxObj.length; i++) {
        if (lieuxObj[i].id == choix) {
            trouver = lieuxObj[i];
        }
    }
    if (trouver) {
        document.getElementById("rue-holder").innerText = trouver.rue;
        document.getElementById("latitude-holder").innerText = trouver.latitude;
        document.getElementById("longitude-holder").innerText = trouver.longitude;
    }
}