let admin_page_img_input = document.getElementById('admin_page_img_input');
if (admin_page_img_input) {
    admin_page_img_input.addEventListener("change", showPreview);

    function showPreview() {
        let src = URL.createObjectURL(admin_page_img_input.files[0]);
        let preview = document.getElementById("form_profile_picture");
        preview.src = src;
    }
}

// let sidebar = document.getElementById("sidebar");
// if (sidebar) {
//     document.addEventListener("scroll", () => {fixed_sidebar()});
//
//     function fixed_sidebar() {
//         if (window.scrollY < 225) {
//             sidebar.classList.remove("fixed-sidebar");
//         } else {
//             sidebar.classList.add("fixed-sidebar");
//         }
//     }
//     fixed_sidebar()
// }