"use strict"

function validateForm() {
    let name = document.forms["myForm"]["fname"].value;
    let mail = document.forms["myForm"]["mail"].value;
    let betreff = document.forms["myForm"]["betreff"].value;
    let nachricht = document.forms["myForm"]["tipp"].value;
    if (name == "" || mail == "" || betreff == "" || nachricht == "") {
        alert("Bitte gebe deine Daten ein");
        return false;
    }
};

function validateFormReservieren() {
    let name = document.forms["myForm"]["name"].value;
    let personen = document.forms["myForm"]["personen"].value;
    let date = document.forms["myForm"]["date"].value;
    let mail = document.forms["myForm"]["mail"].value;
    let phone = document.forms["myForm"]["phone"].value;
    if (name == "" || personen == "" || date == "" || mail == "" || phone == "") {
        alert("Bitte gebe deine Daten ein");
        return false;
    }
};