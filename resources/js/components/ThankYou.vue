<template>
    <Header></Header>
     <section class="bnrsection">
         <!-- <div class="container-fluid">
            <div class="row">
               <div class="col-lg-12 p-0">
                  <img src="dist/img/bnr.jpg" alt="">
               </div>
            </div>
         </div> -->
         <div class="container">
            <div class="row">
                <div class="offset-lg-1 col-lg-10 col-md-12 col-12 text-center">
                    <h2>Thankyou...</h2>
                    <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>

                 </div>
            </div>
        </div>
    </section>
    <Footer></Footer>

</template>

<script setup>
    import Header from './header.vue';
    import Footer from './footer.vue';
</script>
<script>
    export default {
        data(){
            return {
                form:{
                    first_name: "",
                    last_name: "",
                    dob_day: "",
                    dob_month: "",
                    dob_year: "",
                    email: "",
                    phone: "",
                    
                },
                errors:[],
                slide_counter:1
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            submit_form(){
                axios.post('/api/save-user',this.form).then((response)=>{
                    if(response.data.status == 'success'){
                        localStorage.clear()
                        localStorage.setItem('user_email',this.form.email)
                        localStorage.setItem('user_fname',this.form.first_name)
                        toast.fire({
                            'icon': 'success',
                            'title': 'Registered Succesfully',
                        });
                        this.$router.push('/addresses')
                    }
                })
                .catch((error)=>{
                    console.log(error.response.data.errors);
                    this.errors = error.response.data.errors
                    if(this.errors.first_name || this.errors.last_name || this.errors.dob_day || this.errors.dob_month || this.errors.dob_year){
                        this.slide_counter = 1
                    }
                    toast.fire({
                        'icon': 'warning',
                        'title': response.data.message,
                    });
                });
            }
        }
    }
</script>
