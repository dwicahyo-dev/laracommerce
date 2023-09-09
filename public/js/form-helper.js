const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

const ToastBottom = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

function loading() {
    Swal.fire({
        title: "Loading...",
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });
}

function hideLoading() {
    return Swal.close();
}

function resetFormErrorsFields(formId) {
    const form = $(`#${formId}`);
    form.find(".invalid-feedback").detach();
    form.find(`.form-control`).removeClass("is-invalid");
    form.find(`.form-select`).removeClass("is-invalid");
    form.find(".form-group")
        .find(".select2-selection")
        .css("border-color", "#E4E6EF")
        .removeClass("text-danger");
}

function errorFormField(element, key, val) {
    if (element != null) {
        $(`#form-${element} #${key}`).addClass("is-invalid");
        $(`#form-${element} #${key}`).after(
            `<div class="invalid-feedback" role="alert">${val.join(", ")}</div>`
        );
    } else {
        $(`#${key}`).addClass("is-invalid");
        $(`#${key}`).after(
            `<div class="invalid-feedback" role="alert">${val.join(", ")}</div>`
        );
    }
}

function resetFormFields(formId, optionals = {}) {
    const form = $(`#${formId}`);
    $(`#${formId}`)[0].reset();
    form.find(".invalid-feedback").detach();
    form.find(`.form-control`).removeClass("is-invalid");

    if (optionals.custom_validation == true) {
        form.find(".form-group")
            .find(".select2-selection")
            .css("border-color", "#ffffff")
            .removeClass("text-danger");
    }
}

function axiosModalPost(url, data, module, optionals = {}) {
    if (optionals.loading == true) {
        loading();
    }

    axios({ method: data.method, url: url, data: data })
        .then((response) => {
            if (response.status == 201) {
                hideLoading();

                Toast.fire({
                    icon: "success",
                    title: optionals.message
                        ? optionals.message
                        : "Data saved successfully",
                });
            }

            if (response.status == 204) {
                hideLoading();

                Toast.fire({
                    icon: "success",
                    title: optionals.message
                        ? optionals.message
                        : "Data updated successfully",
                });
            }

            $(`#${module}-table`).DataTable().ajax.reload();
            $(`#${module}-modal`).modal("hide");
        })
        .catch((error) => {
            hideLoading();

            if (error.response.status == 422) {
                let err = error.response.data.errors;

                if (optionals.custom_validation == true) {
                    $.each(err, (key, val) => {
                        $(`[name="${key}"]`).addClass("is-invalid");
                        $(`#text-${key}`).after(
                            `<div class="d-inline-block invalid-feedback" role="alert">${val.join(
                                ", "
                            )}</div>`
                        );

                        if (
                            $(`[name="${key}"]`).attr("data-kt-select2") ||
                            $(`[name="${key}"]`).attr("data-control")
                        ) {
                            $(`[name="${key}"]`)
                                .closest(".form-group")
                                .find(".select2-selection")
                                .css("border-color", "#dc3545")
                                .addClass("text-danger");
                        }
                    });

                    return false;
                } else {
                    $.each(err, (key, val) => {
                        errorFormField(module, key, val);
                    });

                    return false;
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Whoops...",
                    text: "Looks Like Something Went Wrong!",
                });
            }
        });
}

function axiosDelete(url, module, module_name, optionals = {}) {
    Swal.fire({
        title: "Are you sure?",
        text: `This action will delete ${module_name}.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        if (result.value) {
            if (optionals.loading == true) {
                loading();
            }

            axios
                .delete(url)
                .then((response) => {
                    if (optionals.loading == true) {
                        hideLoading();
                    }

                    if (
                        response.status == 200 ||
                        response.status == 201 ||
                        response.status == 204
                    ) {
                        Toast.fire({
                            icon: "success",
                            title: optionals.message
                                ? optionals.message
                                : "Data deleted successfully.",
                        });

                        if (optionals.reload) {
                            window.location.reload();
                        }

                        if (optionals.modal_id) {
                            $(`#${optionals.modal_id}`).modal("hide");
                        }

                        $(`#${module}-table`)
                            .DataTable()
                            .ajax.reload(null, true);
                    }

                    if (response.status == 202) {
                        let data = response.data;

                        Swal.fire({
                            icon: "error",
                            title: `${data.title}`,
                            text: `${data.message}`,
                        });
                    }
                })
                .catch((error) => {
                    if (optionals.loading == true) {
                        hideLoading();
                    }

                    if (
                        error.response.status == 424 ||
                        error.response.status == 423 ||
                        error.response.status == 425
                    ) {
                        Swal.fire({
                            icon: "error",
                            title: "Whoops!",
                            text: error.response.data,
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Whoops...",
                            text: "Looks Like Something Went Wrong!",
                        });
                    }
                });
        }
    });
}

function axiosStoreForm(url) {
    axios
        .post(url)
        .then((response) => {
            hideLoading();

            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Form created successfully.",
            }).then(() => {
                window.location.href = route("form-managements.index");
            });
        })
        .catch((error) => {
            hideLoading();

            // if (error.response.status == 424 || error.response.status == 425) {
            //     hideLoading();

            //     Swal.fire({
            //         icon: "error",
            //         title: "Oops...",
            //         text: error.response.data,
            //     });
            // } else

            if (error.response.status == 422) {
                let errData = error.response.data.errors;

                $.each(errData, (key, val) => {
                    $(`#${key}`).addClass("is-invalid");
                    $(`#${key}`).after(
                        `<div class="d-inline-block invalid-feedback" role="alert">${val.join(
                            ", "
                        )}</div>`
                    );
                });
            } else if (error.response.status == 423) {
                Swal.fire({
                    icon: "error",
                    title: "Whoops..",
                    text: "Event Type has already exists in another Form.",
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Whoops...",
                    text: "Looks Like Something Went Wrong!",
                });
            }
        });
}

function axiosUpdateForm(url, data) {
    axios({ method: "PUT", url: url, data: data })
        .then((response) => {
            hideLoading();

            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Form updated successfully.",
            }).then(() => {
                window.location.href = route("form-managements.index");
            });
        })
        .catch((error) => {
            if (error.response.status == 424 || error.response.status == 425) {
                hideLoading();

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: error.response.data,
                });
            } else if (error.response.status == 422) {
                let errData = error.response.data.errors;

                $.each(errData, (key, val) => {
                    $(`#${key}`).addClass("is-invalid");
                    $(`#${key}`).after(
                        `<div class="d-inline-block invalid-feedback" role="alert">${val.join(
                            ", "
                        )}</div>`
                    );
                });
            } else if (error.response.status == 423) {
                hideLoading();

                Swal.fire({
                    icon: "error",
                    title: "Whoops..",
                    text: "Event Type has already exists in another Form.",
                });
            } else {
                hideLoading();

                Swal.fire({
                    icon: "error",
                    title: "Whoops...",
                    text: "Looks Like Something Went Wrong!",
                });
            }
        });
}
