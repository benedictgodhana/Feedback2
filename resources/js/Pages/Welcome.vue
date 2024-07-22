<script setup>
import { reactive } from 'vue';
import Navbar from '@/Components/Navbar.vue'; // Import the Navbar component
import { VCard, VCardTitle, VCardText, VImg, VContainer, VRow, VCol, VCarousel, VCarouselItem, VBtn, VIcon, VFooter } from 'vuetify/components'; // Import Vuetify components

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const state = reactive({
    carouselItems: [
        { src: '/Images/successful-happy-business-team.jpg' },
        { src: '/Images/african-american-business-woman-by-window.jpg' },
        { src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg' },
        { src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg' },
    ],
});
</script>

<template>
    <v-app>
    <Navbar /> <!-- Use the Navbar component -->

    <!-- Carousel Section -->
    <v-carousel height="600" class="mt-16" hide-delimiters="true" show-arrows="hover" cycle>
        <v-carousel-item src="/Images/black-white-portrait-parents-children-sharing-time-together-as-family.jpg" cover></v-carousel-item>
        <v-carousel-item src="/Images/monochrome-portrait-grandmother-with-grandchild-celebration-grandparents-day.jpg" cover></v-carousel-item>
        <v-carousel-item src="/Images/monochrome-portrait-parent-child-showing-affection-sharing-time-together.jpg" cover></v-carousel-item>
    </v-carousel>

    <!-- Information Section -->
    <v-container class="mt-16">
        <v-row>
            <v-col cols="12" md="6">
                <h2 class="text-gray-900 font-bold text-3xl">About Our Benevolent System</h2>
                <p class="mt-4 text-gray-600">
                    Our benevolent system at Strathmore is designed to support and assist those in need within our community. We provide various services and resources to ensure that everyone has access to the help they require.
                </p>
            </v-col>
            <v-col cols="12" md="6">
                <v-img src="https://cdn.vuetifyjs.com/images/cards/desert.jpg" height="300px"></v-img>
            </v-col>
        </v-row>
    </v-container>

    <!-- Download Section -->
    <v-container class="mt-16">
        <h2 class="text-gray-900 font-bold text-3xl">Download Constitutions</h2>
        <v-row>
            <v-col cols="12" md="4">
                <v-card>
                    <v-card-title>Constitution 2021</v-card-title>
                    <v-card-text>
                        Download the 2021 constitution.
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" href="path/to/constitution2021.pdf" download>
                            <v-icon left>mdi-download</v-icon>
                            Download
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card>
                    <v-card-title>Constitution 2022</v-card-title>
                    <v-card-text>
                        Download the 2022 constitution.
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" href="path/to/constitution2022.pdf" download>
                            <v-icon left>mdi-download</v-icon>
                            Download
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card>
                    <v-card-title>Constitution 2023</v-card-title>
                    <v-card-text>
                        Download the 2023 constitution.
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" href="path/to/constitution2023.pdf" download>
                            <v-icon left>mdi-download</v-icon>
                            Download
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>

    <!-- Footer Section -->
    <v-footer class="footer" style="background-color: darkblue;color:white  ">
        <v-container>
            <v-row>
                <v-col cols="12" md="4">
                    <v-img src="/Images/logo.png" height="60" contain></v-img>
                </v-col>
                <v-col cols="12" md="4">
                    <h3>Contact Us</h3>
                    <p>Email: info@strathmore.edu</p>
                    <p>Phone: +254 700 000 000</p>
                </v-col>
                <v-col cols="12" md="4">
                    <h3>Follow Us</h3>
                    <v-btn icon>
                        <v-icon>mdi-facebook</v-icon>
                    </v-btn>
                    <v-btn icon>
                        <v-icon>mdi-twitter</v-icon>
                    </v-btn>
                    <v-btn icon>
                        <v-icon>mdi-instagram</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-footer>

</v-app>
</template>

<style scoped>
.pt-32 {
    padding-top: 8rem;
}
.md\\:py-12 {
    padding-top: 3rem;
    padding-bottom: 3rem;
}
.mt-16 {
    margin-top: 4rem;
}
.v-carousel-item .v-image__image--contain {
    object-fit: contain;
}
.footer {
    background-color: #f5f5f5; /* Light gray background */
    padding: 2rem 0; /* Padding for top and bottom */
    position: relative;
    bottom: 0;
    width: 100%;
}
</style>
