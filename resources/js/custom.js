window.$ = window.jQuery = require('jquery');
require('owl.carousel');
window.popper = require('@popperjs/core');
require('bootstrap');

$('#crypto-price-line .owl-carousel').owlCarousel({
    loop: true,
    nav: false,
    autoplay: true,
    dots: false,
    slideTransition: 'linear',
    autoplayTimeout: 2000,
    autoplaySpeed: 2000,
    autoplayHoverPause: false,
    touchDrag: false,
    mouseDrag: false,
    center: true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1200:{
            items:7
        }
    }
})

$('.home-owl-carousel').owlCarousel({
    loop: true,
    autoplay: true,
    nav: false,
    dots: false,
    responsive:{
        0:{
            items:1
        }
    }
})

let contact_form = document.getElementById("contact_form");
if (contact_form) {
    document.contactform = undefined;
    // Form validation script
    // Defining a function to display error message
    function printError(elemId, hintMsg) {
        document.getElementById(elemId).innerHTML = hintMsg;
    }

    // Defining error variables with a default value
    let nameErr, emailErr, commentErr;
    nameErr = emailErr = commentErr = true;
    let inp_name = document.getElementById("name");
    let inp_email = document.getElementById("email");
    let inp_comment = document.getElementById("message");
    let form_btn = document.getElementById("form-button");

    inp_name.addEventListener("focusout", validate_form_name);
    inp_email.addEventListener("focusout", validate_form_email);
    inp_comment.addEventListener("focusout", validate_form_comment);

    inp_name.addEventListener("input", validate_form_name_rem);
    inp_email.addEventListener("input", validate_form_email_rem);
    inp_comment.addEventListener("input", validate_form_comment_rem);

    form_btn.addEventListener("click",() => {validate_form_name(); validate_form_email(); validate_form_comment()});

    let $fa_warning = "<i class='fa-solid fa-triangle-exclamation' aria-hidden='true'></i>";

    // Validate name
    function validate_form_name() {
        let name = inp_name.value;
        if (name === "") {
            printError("nameErr", $fa_warning + " Please enter your name");
            inp_name.classList.add("input-error");
            nameErr = true;
        } else {
            let regex = /^[a-zA-Z\s]+$/;
            if(regex.test(name) === false) {
                printError("nameErr", $fa_warning + " You can only use alphabetical letters and spaces");
                inp_name.classList.add("input-error");
                nameErr = true;
            }
        }
    }

    // Remove the error if the user fixes the problem while typing
    function validate_form_name_rem() {
        let name = inp_name.value;
        if (name !== "") {
            let regex = /^[a-zA-Z\s]+$/;
            if (regex.test(name) === true) {
                inp_name.classList.remove("input-error");
                printError("nameErr", "");
                nameErr = false;
            }
        }
    }

    // Validate email
    function validate_form_email() {
        let email = inp_email.value;
        if (email === "") {
            printError("emailErr", $fa_warning + " Please enter your email address");
            inp_email.classList.add("input-error");
            emailErr = true;
        } else {
            // Regular expression for basic email validation
            let regex = /^\S+@\S+\.\S+$/;
            if (regex.test(email) === false) {
                printError("emailErr", $fa_warning + " Please enter a valid email address");
                inp_email.classList.add("input-error");
                emailErr = true;
            }
        }
    }

    // Remove the error if the user fixes the problem while typing
    function validate_form_email_rem() {
        let email = inp_email.value;
        if (email !== "") {
            // Regular expression for basic email validation
            let regex = /^\S+@\S+\.\S+$/;
            if (regex.test(email) === true) {
                inp_email.classList.remove("input-error");
                printError("emailErr", "");
                emailErr = false;
            }
        }
    }

    // Validate message
    function validate_form_comment() {
        let comment = inp_comment.value;
        if (comment === "") {
            printError("commentErr", $fa_warning + " This field cannot be empty");
            inp_comment.classList.add("input-error");
            commentErr = true;
        } else {
            if (comment.length > 2500) {
                printError("commentErr", $fa_warning + " Your message is too long, the max characters are 2500");
                inp_comment.classList.add("input-error");
                commentErr = true;
            }
        }
    }

    // Remove the error if the user fixes the problem while typing
    function validate_form_comment_rem() {
        let comment = inp_comment.value;
        if (comment !== "") {
            if (comment.length < 2500) {
                inp_comment.classList.remove("input-error");
                printError("commentErr", "");
                commentErr = false;
            }
        }
    }

    document.getElementById("form-button").addEventListener("click", validateForm)

    // Prevent the form from being submitted if there are any errors
    function validateForm() {
        if ((nameErr || emailErr || commentErr) === true) {
            return false;
        } else {
            document.getElementById("contact_form").submit();
        }
    }
}