<template>
    <app-layout>
        <!-- <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
        </template> -->
        <hero-banner />

        <template v-slot:main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h1>Main content</h1>
                    </div>
                </div>
            </div>
        </template>

        <template v-slot:footer>
            <h2>Footer</h2>
        </template>
    </app-layout>
</template>

<script>
    import HeroBanner from '@/Pages/HeroBanner'
    import AppLayout from '@/Layouts/AppLayout'
    // import HeroBunner from '@/Pages/HeroBunner'

    export default {
        components: {
            AppLayout,
            HeroBanner
        },

        created() {
        }
    }

</script>