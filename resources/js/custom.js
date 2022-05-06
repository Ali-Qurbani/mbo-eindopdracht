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
    nav: true,
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

// Crypto calculator script
let crypto_calculator = document.getElementById("crypto-calculator")
if (crypto_calculator) {
    let left_icon = document.getElementById('calc-1-icon');
    let left_input = document.getElementById('calc-inp-1');
    let left_select = document.getElementById('calc-left-select');
    let left_help = document.getElementById('left-help')

    let right_input = document.getElementById('calc-inp-2');
    let right_help = document.getElementById('right-help')

    left_select.addEventListener("change", calc_update)
    left_input.addEventListener("input", calc_update_right)
    right_input.addEventListener("input", calc_update_left)

    function calc_update() {
        left_icon.src = left_select.options[left_select.selectedIndex].id;
        left_input.value = 1;
        right_input.value = left_select.value;
        left_help.innerHTML = '1 ' + left_select.options[left_select.selectedIndex].innerHTML + ' is ' + left_select.options[left_select.selectedIndex].value + ' Tether';
        right_help.innerHTML = '1 ' + 'Tether' + ' is ' + 1 / left_select.options[left_select.selectedIndex].value + ' ' + left_select.options[left_select.selectedIndex].innerHTML;
    }
    calc_update()

    function calc_update_left() {
        let coin_to_usdt = left_select.options[left_select.selectedIndex].value;
        left_input.value = right_input.value / coin_to_usdt;
    }

    function calc_update_right() {
        let coin_to_usdt = left_select.options[left_select.selectedIndex].value;
        right_input.value = left_input.value * coin_to_usdt;
    }
}

$(".alert").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert").slideUp(500);
});

// FAQ dropdowns
let coll = document.getElementsByClassName("collapsible");
let i;

for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        let content = this.nextElementSibling;
        if (content.style.maxHeight){
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
}

let password_Box = document.getElementById("show_password_box");
if (password_Box) {
    password_Box.addEventListener("click", toggle_vis)
    let input = document.getElementById("password");
    function toggle_vis()
    {
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
}