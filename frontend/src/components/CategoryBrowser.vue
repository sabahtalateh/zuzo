<template>
    <ul class="menu-list">
        <li @click="expandNode" class="node" :style="{'margin-left': `${depth * 20}px`}">
            <a :class="{ 'is-active': node.active }">
                <span class="expand-wrapper">
                    <span v-if="hasChildren">{{ expanded ? '-' : '+' }}</span>
                    <span v-else="hasChildren">▪</span>
                </span>
                {{ node.name }}
            </a>
        </li>
        <CategoryBrowser
            v-if="expanded"
            v-for="child in node.children"
            :key="child.name"
            :node="child"
            :depth="child.depth"
            @onClick="(node) => $emit('onClick', node)"
        />
    </ul>
</template>

<script>
export default {
    name: 'CategoryBrowser',
    props: {
        node: Object,
        loaded: false,
        depth: {
            type: Number,
            default: 0,
        }
    },
    components: {
        CategoryBrowser: () => import('./CategoryBrowser')
    },
    data() {
        return {
            expanded: false,
        }
    },
    methods: {
        expandNode() {
            this.expanded = !this.expanded
            this.$emit('onClick', this.node)
        },
    },
    computed: {
        hasChildren() {
            return Array.isArray(this.node.children)
        }
    },
}
</script>

<style scoped>
    .node {
        cursor: default;
    }
    .expand-wrapper {
        display: inline-block;
        width: 12px;
    }
</style>
