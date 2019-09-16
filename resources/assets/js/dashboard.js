import Vue from 'vue';
import axios from 'axios';
import Chart from 'chart.js';

new Vue({
    el: '#dw',
    data: {
        //FORMAT DATA YANG AKAN DIGUNAKAN KE CHART.JS
        dwChartData: {
            type: 'line',
            data: {
                //YANG PERLU DIPERHATIKAN BAGIAN LABEL INI NILAINYA DINAMIS
                labels: [],
                datasets: [
                    {
                        label: 'Total Penjualan',
                        //DAN NILAI DATA JUGA DINAMIS TERGANTUNG DATA YANG DITERIMA DARI SERVER
                        data: [],
                        backgroundColor: [
                            'rgba(71, 183,132,.5)',
                            'rgba(71, 183,132,.5)',
                            'rgba(71, 183,132,.5)',
                            'rgba(71, 183,132,.5)',
                            'rgba(71, 183,132,.5)',
                            'rgba(71, 183,132,.5)',
                            'rgba(71, 183,132,.5)'
                        ],
                        borderColor: [
                            '#47b784',
                            '#47b784',
                            '#47b784',
                            '#47b784',
                            '#47b784',
                            '#47b784',
                            '#47b784'
                        ],
                        borderWidth: 3
                    }
                ]
            },
            options: {
                responsive: true,
                lineTension: 1,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            padding: 25,
                        }
                    }]
                }
            }
        }
    },
    mounted() {
        this.getData();
        this.createChart('dw-chart', this.dwChartData);
    },
    methods: {
        createChart(chartId, chartData) {
            //MENCARI ELEMEN DENGAN ID SESUAI DARI PARAMETER chartId
            const ctx = document.getElementById(chartId);
            //MENDEFINISIKAN CHART.JS
            const myChart = new Chart(ctx, {
                type: chartData.type,
                data: chartData.data,
                options: chartData.options,
            });
        },
        //METHOD getData() UNTUK MEMINTA DATA DARI SERVER
        getData() {
            axios.get('/api/chart')
            .then((response) => {
                //DILOOPING DENGAN MEMISAHKAN KEY DAN VALUE
                Object.entries(response.data).forEach(
                    ([key, value]) => {
                        //DIMANA KEY (BACA: DALAM HAL INI INDEX DATA ADALAH TANGGAL)
                        //KITA MASUKKAN KEDALAM dwChartData > data > labels
                        this.dwChartData.data.labels.push(key);
                        //KEMUDIAN VALUE DALAM HAL INI TOTAL PESANAN
                        //KITA MASUKKAN KE DALAM dwChartData > data > datasets[0] > data
                        this.dwChartData.data.datasets[0].data.push(value);
                    }
                );
            })
        }
    }
})
