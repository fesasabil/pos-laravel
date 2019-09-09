import Vue from 'vue'
import axios from 'axios'

//import sweetalert library
import VueSweetalert2 from 'vue-sweetalert2';

Vue.filter('currency', function (money) {
    return accounting.formatMoney(money, "Rp ", 2, ".", ",")
})

new Vue({
    el: '#dw',
    data: {
        product: {
            id: '',
            qty: '',
            price: '',
            name: '',
            photo: ''
        }
    },

    watch: {
        //apabila nilai dari product > id berubah maka
        'product.id': function() {
            //mengecek jika nilai dari product > id ada
            if(this.product.id) {
                    //maka akan menjalankan methods getProduct
                    this.getProduct()
            }
        }
    },

    //menggunakan library select2 ketika file ini di-load
    mounted() {
        $('#product_id').select2({
            width:'100%'
        }).on('change', () => {
            //apabila terjadi perubahan nilai yg dipilih maka nilai tersebut akan disimpan di dalam var product > id
            this.product.id = $('#product_id').val();
        });
            //memanggil method getCart() untuk me-load cookie cart
            this.getCart()
            
    },

    methods: {
        getProduct() {
            //fetch ke server menggunakan axios dengan mengirimkan parameter id dengan url /api/product/{id}
            axios.get('/api/product/${this.product.id}')
            .then((response) => {
                //assign data yang diterima dari server ke var product
                this.product = response.data
            })
        },

        //method untuk menambahkan product yang dipilih ke dalam cart
        addToCart() {
            this.submitCart = true;

            //send data to server
        }
    }
})