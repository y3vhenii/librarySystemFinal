/*
    This function is used on the index page to validate users input (name and card number)
    Simply checks if the numbers are in the valid range, will be checked later with Database
*/
function validate() {
    var patroName = document.getElementById("custName").value;
    var cardNum = document.getElementById("custCard").value;
        if(patroName == ""){
            alert("\"Patron name\" you entered is incorrect. Try again...");
            return false;
        }
        else if(cardNum.length < 8){
            alert("The \"Patron card number\" you entered is too short. Try again...");
            return false;
        }
        else if(cardNum.length > 8){
            alert("The \"Patron card number\" you entered is too long. Try again...");
            return false;
        }
}

/*
    This function is used on the account creation page to validate users input (name, card number and email)
    Simply checks whether the form contains valid data in order to cleanse the data passed to PHP
*/
function validateaccount() {
    var patrName = document.getElementById("patName").value;
    var crdNum = document.getElementById("patCardNum").value;
    var patronEmail = document.getElementById("patEmail").value;
    if(patrName == ""){
        alert("You forgot to enter \"Patron name\". Try again...");
        return false;
    }
    else if(crdNum.length < 8){
        alert("The \"Patron card number\" you entered is too short. Try again...");
        return false;
    }
    else if(crdNum.length > 8){
        alert("The \"Patron card number\" you entered is too long. Try again...");
        return false;
    }
    else if (patronEmail.indexOf('\@') < 1 || patronEmail.indexOf('\.') < 1){
        alert("The \"Patron email\" you entered is incorrect. Try again...");
        return false;
    }
}

/*
    This function is used to validate the new account form information
    Other fucntions are not used in order to prevent bugs in code
*/
function validateNewAccountEntry() {
    var patrName = document.getElementById("newPatName").value;
    var crdNum = document.getElementById("newPatCardNum").value;
    var patronEmail = document.getElementById("newPatEmail").value;
    if(patrName == ""){
        alert("You forgot to enter \"Patron name\". Try again...");
        return false;
    }
    else if(crdNum.length < 8){
        alert("The \"Patron card number\" you entered is too short. Try again...");
        return false;
    }
    else if(crdNum.length > 8){
        alert("The \"Patron card number\" you entered is too long. Try again...");
        return false;
    }
    else if (patronEmail.indexOf('\@') < 1 || patronEmail.indexOf('\.') < 1){
        alert("The \"Patron email\" you entered is incorrect. Try again...");
        return false;
    }
}
