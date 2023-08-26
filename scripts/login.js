"use strict";

function validate() {
  // initialize local variables
  var result = true;

  // Email
  // Email Pattern taken from https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
  var email_pattern =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  var Email = document.getElementById("Email").value.trim();
  if (!email_pattern.test(String(Email).toLowerCase())) {
    document.getElementById("Email").classList.add("is-invalid");
    document.getElementById("Email").classList.remove("is-valid");
    result = false;
  } else {
    document.getElementById("Email").classList.add("is-valid");
    document.getElementById("Email").classList.remove("is-invalid");
  }

  // Password
  var Password = document.getElementById("Password").value.trim();
  if (!Password.match(/^[A-Za-z@'0-9]{8,20}$/)) {
    document.getElementById("Password").classList.add("is-invalid");
    document.getElementById("Password").classList.remove("is-valid");
    result = false;
  } else {
    document.getElementById("Password").classList.add("is-valid");
    document.getElementById("Password").classList.remove("is-invalid");
  }

  return result;
}

function init() {
  var form = document.getElementById("form");
  let run_validate = true;
  if (run_validate) {
    form.onsubmit = validate;
  }
}

window.addEventListener("load", init);
