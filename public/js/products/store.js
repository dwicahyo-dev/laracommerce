const axiosStore = (url, data, module, optionals = {}) => {
    axios({ method: "POST", url: url, data: data })
        .then((response) => {
            if (response.status == 201) {
                hideLoading();

                Toast.fire({
                    icon: "success",
                    title: optionals.message
                        ? optionals.message
                        : "Data saved successfully",
                }).then(() => {
                    console.log("sdfadfdf");

                    window.location.href = route("admin.products.index");
                });
            }
        })
        .catch((error) => {
            hideLoading();

            if (error.response.status == 422) {
                let err = error.response.data.errors;

                $.each(err, (key, val) => {
                    errorFormField(module, key, val);
                });

                return false;
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Whoops...",
                    text: "Looks Like Something Went Wrong!",
                });
            }
        });
};
