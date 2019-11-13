<template>
    <div>
        <div class="card">
            <div class="card-image">
                <figure class="image is-4by3">
                    <img :src="`${product.image}`" :alt="`${product.name}`">
                </figure>
            </div>
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4">{{ product.name }}</p>
                    </div>
                </div>

                <div class="content">
                    {{ product.details }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProductsBrowser',
    props: {
        product: {
            name: String,
            details: String,
            image: String,
        }
    }
}
</script>
