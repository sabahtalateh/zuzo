<template>
    <div>
        <Navbar/>
        <router-view/>
    </div>
</template>

<script>
    export default {
        name: 'app',
        components: {
            Navbar: () => import('./components/Navbar')
        }
    };
</script>

<style scoped>
</style>
