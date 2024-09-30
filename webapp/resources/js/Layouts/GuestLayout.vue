<template>

    <div class="bg-[#D13E56] min-h-screen flex items-center justify-center">

        <v-card class="w-full sm:max-w-md mt-6 px-6 py-4 opacity-95">
            <v-card-title class="font-weight-black text-h4 text-center text-uppercase text-primary">
                Geoglify
            </v-card-title>
            <slot />
        </v-card>

        <!-- footer logo copywritg-->
        <div class="absolute bottom-2 w-full text-center text-white">
            <p class="text-xs">Desenvolvido pela leoneljdias © {{ new Date().getFullYear() }} Geoglify</p>
        </div>
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