<template>
    <Header :categories="data.package_categories" />
    <router-view></router-view>
    <Footer />
</template>

<script>
import Header from "./header.vue";
import Footer from "./footer.vue";

export default {
    name: "Main_page",
    components: {
        Header, Footer
    },
    data() {
        return {
        };
    },
    props: ["data"],
    methods: {
    },
};
</script>

<style></style>
