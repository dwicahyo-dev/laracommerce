document.addEventListener("alpine:init", () => {
    let store = Alpine.store("products", {
        product: {
            name: "",
            description: "",
            price: "",
            image: "",
            image_url: "",
        },
        store() {
            resetFormErrorsFields("form-products");

            const data = {
                name: this.product.name,
                category_id: this.product.category_id,
                description: this.product.description,
                price: this.product.price,
                image: this.product.image,
                image_url: this.product.image_url,
            };

            const url = route("admin.products.store");

            axiosStore(url, data, "products");
        },
        imageOnChanged(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            if (event.target.files.length < 1) {
                return;
            }

            reader.readAsDataURL(file);
            reader.onload = () => (this.product.image_url = reader.result);

            this.product.image = file.name;
        },
        init() {
            //
        },
    });

    return store;
});
