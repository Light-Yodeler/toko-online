import "./bootstrap";
import Swal from "sweetalert2";
import $ from "jquery";
import DataTable from "datatables.net-dt";
import "datatables.net-dt/css/dataTables.dataTables.css";
window.$ = $;
window.jQuery = $;

// after input notify
$(function () {
    if (window.flashMessage && window.flashMessage.message) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end", // pojok kanan atas
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        Toast.fire({
            icon: window.flashMessage.type || "info",
            title: window.flashMessage.message,
        });
    }
});

$(function () {
    $("#users-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: "/user/data", // route ke controller datatable
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "username",
                name: "username",
            },
            {
                data: "email",
                name: "email",
            },
            {
                data: "role",
                name: "role",
            },
            {
                data: "photo",
                name: "photo",
                orderable: false,
                searchable: false,
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
});
$(document).on("click", ".delete-btn", function (e) {
    e.preventDefault();

    let id = $(this).data("id"); // ambil id dari tombol
    let form = $("#delete-form-" + id); // ambil form sesuai id

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // submit form jika user setuju
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end", // pojok kanan atas
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "success",
                title: "data berhasil dihapus",
            });
        }
    });
});

function path(path) {}

$(document).ready(function () {
    //preview image
    document
        .getElementById("photo")
        .addEventListener("change", function (event) {
            const [file] = event.target.files; // ambil file pertama
            const preview = document.getElementById("photoPreview");

            if (file) {
                preview.src = URL.createObjectURL(file); // buat URL lokal sementara
                preview.classList.remove("hidden"); // tampilkan preview
            }

            // else {
            //     preview.classList.add("hidden"); // sembunyikan kalau tidak ada file
            // }
        });
});
