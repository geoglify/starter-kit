<template>
    <div :class="isMobile ? 'bg-white' : 'bg-red-400'"
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <v-card class="w-full sm:max-w-md mt-6 px-6 py-4" :color="isMobile ? 'white' : 'white'"
            :elevation="isMobile ? 0 : 5">
            <v-card-title class="font-weight-black text-h3 text-center text-uppercase">
                Geoglify
            </v-card-title>
            <slot />
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isMobile: false
        };
    },
    mounted() {
        this.checkViewport();
        window.addEventListener('resize', this.checkViewport);
    },
    methods: {
        checkViewport() {
            this.isMobile = window.innerWidth < 640; // sm breakpoint do Tailwind
        }
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.checkViewport);
    }
};
</script>

<style>
html,
body {
    overflow: hidden;
}
</style>
