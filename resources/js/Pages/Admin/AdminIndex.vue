<template>
    <Head title="Dashboard" />

    <AdminLayout :categories="categories" >
        <v-container fluid>
            <v-row>
                <!-- Feedback Cards -->
                <v-col cols="12" md="6" lg="3">
                    <v-card class="pa-3" elevation="14" rounded>
                        <v-card-title style="background-color: darkblue; color:white">Today's Feedback</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text style="font-size:18px;font-weight: 700;">{{ totalFeedback }}</v-card-text>
                        <v-btn width="100%" color="orange" style="text-transform: none;">View Today's Feedback</v-btn>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="3">
                    <v-card class="pa-3" elevation="14" rounded>
                        <v-card-title style="background-color: darkblue; color:white">Today's Feedback</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text style="font-size:18px;font-weight: 700;">{{ todaysFeedback }}</v-card-text>
                        <v-btn width="100%" color="orange" style="text-transform: none;">View Today's Feedback</v-btn>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="3">
                    <v-card class="pa-3" elevation="14" rounded>
                        <v-card-title style="background-color: darkblue; color:white">This Week's Feedback</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text style="font-size:18px;font-weight: 700;">{{ weeksFeedback }}</v-card-text>
                        <v-btn width="100%" color="orange" style="text-transform: none;">View This Week's Feedback</v-btn>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="3">
                    <v-card class="pa-3" elevation="14" rounded>
                        <v-card-title style="background-color: darkblue; color:white">Monthly Feedback</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text style="font-size:18px;font-weight: 700;">{{ monthlyFeedback }}</v-card-text>
                        <v-btn width="100%" color="orange" style="text-transform: none;">View Monthly Feedback</v-btn>
                    </v-card>
                </v-col>

                <!-- Feedback Categories Cards -->
                <v-col cols="12" md="6" lg="" v-for="category in categories" :key="category.name">
                    <v-card class="pa-3" elevation="14" rounded>
                        <v-card-title class="d-flex align-center" style="background-color: orangered; color:white">
                            <v-icon>{{ category.icon }}</v-icon>
                            <span class="ml-2">{{ category.name }}</span>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text style="font-size:18px;font-weight: 700;">{{ category.feedback_count }} feedback(s)</v-card-text>
                        <v-btn :href="category.url" width="100%" style="text-transform: none;background-color: darkblue;color:white;">View Feedback <v-icon>mdi-chevron-right</v-icon></v-btn>
                    </v-card>
                </v-col>

                <!-- Highcharts for Feedback Overview -->
                <v-col cols="12">
                    <v-card class="pa-3" elevation="5">
                        <v-card-title class="text-center" style="background-color:orange; color:white">Feedback Overview</v-card-title>
                        <v-divider></v-divider>
                        <highcharts :options="feedbackChartOptions" :key="feedbackChartKey"></highcharts>
                        <v-btn-toggle v-model="selectedFeedbackChartType" mandatory>
                            <v-btn @click="switchFeedbackGraph('line')" style="background-color: darkblue; color:white">
                                <v-icon>mdi-chart-line</v-icon>
                                Line
                            </v-btn>
                            <v-btn @click="switchFeedbackGraph('bar')" style="background-color: orange; color:white">
                                <v-icon>mdi-chart-bar</v-icon>
                                Bar
                            </v-btn>
                            <v-btn @click="switchFeedbackGraph('pie')" style="background-color: green; color:white">
                                <v-icon>mdi-chart-pie</v-icon>
                                Pie
                            </v-btn>
                        </v-btn-toggle>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>

<script>
import Highcharts from 'highcharts';
import HighchartsVue from 'highcharts-vue';
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
    name: 'Dashboard',
    components: {
        Head,
        AdminLayout,
        highcharts: HighchartsVue.component,
    },
    props: {
        totalUsers: Number,
        todaysFeedback: Number,
        weeksFeedback: Number,
        monthlyFeedback: Number,
        categories: Array,
        feedbackChartData: Array,
        totalFeedback: Number,
    },
    data() {
        return {
            feedbackChartKey: 0,
            feedbackChartOptions: {
                chart: {
                    type: 'line',
                },
                title: {
                    text: 'Feedback Overview by Category',
                },
                xAxis: {
                    categories: this.feedbackChartData.map(item => item.name),
                    title: {
                        text: 'Category',
                    },
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Feedback Count',
                    },
                },
                series: [{
                    name: 'Feedback Count',
                    data: this.feedbackChartData.map(item => item.data),
                    color: 'green',
                }],
            },
            selectedFeedbackChartType: 'line',
        };
    },
    methods: {
        switchFeedbackGraph(type) {
            this.feedbackChartOptions.chart.type = type;
            if (type === 'pie') {
                this.feedbackChartOptions = {
                    chart: {
                        type: 'pie',
                    },
                    title: {
                        text: 'Feedback Distribution by Category',
                    },
                    series: [{
                        name: 'Feedback Count',
                        colorByPoint: true,
                        data: this.feedbackChartData.map(item => ({
                            name: item.name,
                            y: item.data,
                            color: this.getColor(item.name),
                        })),
                    }],
                };
            } else {
                this.feedbackChartOptions = {
                    chart: {
                        type: type,
                    },
                    title: {
                        text: 'Feedback Overview by Category',
                    },
                    xAxis: {
                        categories: this.feedbackChartData.map(item => item.name),
                        title: {
                            text: 'Category',
                        },
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Feedback Count',
                        },
                    },
                    series: [{
                        name: 'Feedback Count',
                        data: this.feedbackChartData.map(item => item.data),
                        color: 'green',
                    }],
                };
            }
            this.feedbackChartKey += 1;
        },
        getColor(name) {
            const colors = {
                'Suggestions': 'red',
                'Compliments': 'blue',
                'Others': 'green',
                'Complaints': 'orange',

                // Add more category colors as needed
            };
            return colors[name] || 'gray';
        },
    },
    mounted() {
        Highcharts.setOptions({
            colors: ['green'],
        });
    },
};
</script>

<style scoped>
/* Add scoped styles here */
</style>
