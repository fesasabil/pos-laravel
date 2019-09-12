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
        },

        customer: {
            email: ''
        },
        formCustomer: false,
        resultStatus: false,
        submitForm: false,
        errorMessage: '',
        message: ''
    },

    watch: {
        //apabila nilai dari product > id berubah maka
        'product.id': function() {
            //mengecek jika nilai dari product > id ada
            if(this.product.id) {
                    //maka akan menjalankan methods getProduct
                    this.getProduct()
            }
        },

        'customer.email': function() {
            this.formCustomer = false
            if (this.customer.name != '') {
                this.customer = {
                    name: '',
                    phone: '',
                    address: ''
                }
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
            axios.post('/api/cart', this.cart)
            .then((response) => {
                setTimeout(() => {
                    //apabila berhasil, data disimpan ke dalam var shoppingCart
                    this.shoppingCart = response.data

                    //mengosongkan var
                    this.cart.product_id = ''
                    this.cart.qty = 1
                    this.product = {
                        id: '',
                        price: '',
                        name: '',
                        photo: ''
                    }
                    $('#product_id').val('')
                    this.submitCart = false
                }, 2000)
            })
            .catch((error) => {

            })
        },

        //mengambil list cart yang telah disimpan
        getCart() {
            //fetch data to server
            axios.get('/api/cart')
            .then((response) => {
                //data yang diterima disimpan ke dalam var shoppingCart
                this.shoppingCart = response.data
            })
        },

        //remove cart
        removeCart(id) {
            //menampilkan konfirmasi dengan sweetalert
            this.$swal({
                title: 'You are sure?',
                text: 'You Cannot Revert This Action!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Continue!',
                cancelButtonText: 'No, Cancel!',
                showCloseButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve()
                        }, 2000)
                    })
                },
                allowOutsideClick: () => !this.$swal.isLoading()
            }).then ((result) => {
                 //apabila disetujui
                 if(result.value) {
                     //send data to server
                     axios.delete('/api/cart/${id}')
                     .then ((response) => {
                         //load new cart
                         this.getCart();
                     })
                     .catch ((error) => {
                         console.log(error);
                     })
                 }
            })
        },

        searchCustomer() {
            axios.post('/api/customer/search', {
                email: this.customer.email
            })
            .then((response) => {
                if (response.data.status == 'success') {
                    this.customer = response.data.data
                    this.resultStatus = true
                }
                this.formCustomer = true
            })
            .catch((error) => {

            })
        },

        sendOrder() {
            this.errorMessage = ''
            this.message = ''
            if (this.customer.email != '' && this.customer.name != '' && this.customer.phone != '' && this.customer.address != '') {
                this.$swal({
                    title: 'You are sure?',
                    text: 'You cannot reverse this action!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, continue!',
                    cancelButtonText: 'No, Cancel!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: () =>{
                        return new Promise((resolve) => {
                            setTimeout(() => {
                                resolve()
                            }, 2000)
                        })
                    },
                    allowOutsideClick: () => this.$swal.isLoading()
                }).then ((result) => {
                    if (result.value) {
                        this.submitForm = true
                        axios.post('/checkout', this.customer)
                        .then((response) => {
                            setTimeout(() => {
                                this.getCart();
                                this.message = response.data.message
                                this.customer = {
                                    name: '',
                                    phone: '',
                                    address: ''
                                }
                                this.submitForm = false
                            }, 1000)
                        })
                        .catch(( error ) => {
                            console.log(error)
                        })
                    }
                })
            } else {
                this.errorMessage = 'there is still an empty input!'
            }
        }
    }
})