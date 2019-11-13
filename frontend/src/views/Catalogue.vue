<template>
    <div>

        <div class="container is-flex">
            <div class="column">
                <CategoriesTreeBrowser
                    v-for="category in categories"
                    :key="category.id"
                    :node="category"
                    :depth="category.depth"
                    @onClick="nodeClicked"/>
            </div>
            <div class="column">
                <ProductsBrowser
                    v-for="product in products"
                    :key="product.id"
                    :product="product"
                />
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import { findObjectByPropRecursive, setPropRecursive } from '../helpers'

import ApiEndpoints from '../ApiEndpoints'

export default {
    name: 'Catalogue',
    data() {
        return {
            categories: [],
            products: [],
        }
    },
    components: {
        CategoriesTreeBrowser: () => import('../components/CategoryBrowser'),
        ProductsBrowser: () => import('../components/ProductsBrowser'),
    },
    methods: {
        updateCategoryBrowser: function (node) {
            const updatedList = _.cloneDeep(this.categories)
            setPropRecursive(updatedList, 'active', false)
            const updatedNode = findObjectByPropRecursive(updatedList, 'id', node.id)
            updatedNode.active = true
            if (!node.loaded) {
                this.$http.get(ApiEndpoints.category(node.id))
                    .then(res => {
                        const children = res.body.data
                        if (Array.isArray(children) && children.length > 0) {
                            if (updatedNode) {
                                updatedNode.children = children
                            }
                        }
                        updatedNode.loaded = true
                        this.categories = updatedList
                    })
                    .catch(err => console.error(err))
            } else {
                this.categories = updatedList
            }
        },
        nodeClicked(node) {
            this.updateCategoryBrowser(node)

            this.$http.get(ApiEndpoints.products(node.id))
                .then(res => {
                    this.products = res.body.data
                })
                .catch(err => console.log(err))
        }

    },
    mounted() {
        this.$http.get(ApiEndpoints.categories)
            .then(res => {
                this.categories = res.body.data
            })
            .catch(err => console.error(err));
    }
}
</script>
