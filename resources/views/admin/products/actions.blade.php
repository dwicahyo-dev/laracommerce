<button type="button" class="btn btn-danger" @click.prevent="$store.products.delete({{ json_encode($object) }})">
    Delete
</button>