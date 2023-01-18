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
                  <h1>Hi <span></span> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h1>
                  <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
               </div>
               <div class="offset-lg-2 col-lg-8 offset-md-1 col-md-10 col-12 text-center">
                  <div class="formpart">
                     <form @submit.prevent="submit_form()">
                        <div v-if="form_counter == 0">
                           <h3>Do you have a Previous Address?</h3>
                           <div class="form-check" @click="form_counter = 1">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label next02" for="flexRadioDefault1">
                              Yes
                            </label>
                          </div>
                          <div class="form-check" @click="$router.push('/thank-you')">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                            <label class="form-check-label tothank" for="flexRadioDefault2">
                              No
                            </label>
                          </div>
                        </div>
                        
                        
                        
                        
                        <div v-if="form_counter == 1">
                           <h3>Enter your Previous Address</h3>
                            <div class="mb-3 text-start" v-for="(a,key) in addresses" :key="key">
                                <label class="form-label">Previous Address {{key + 1}}</label>
                                <input type="text" v-model="addresses[key].address_line_1" class="form-control mb-3" id="" placeholder="Address line 1">
                                <input type="text" v-model="addresses[key].address_line_2" class="form-control mb-3" id="" placeholder="Address line 2">
                                <input type="text" v-model="addresses[key].address_line_3" class="form-control mb-3" id="" placeholder="Address line 3">
                            </div>
                            <div class="mb-3 text-center" id="submitoradd01">
                                <button type="submit" class="btn btn-success tothank">Submit</button>
                                <p class="text-primary pointer" @click="add_obj()">Add Another Address</p>
                                <p class="text-primary pointer" v-if="addresses.length > 1" @click="addresses.pop()">Remove Address</p>
                                <p class="text-primary pointer" @click="form_counter = 0">{{'<<'}} Back</p>
                            </div> 
                        </div>
                     </form>
                  </div>
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
                addresses:[],
                errors:[],
                form_counter:0,
                default_obj:{
                    'address_line_1':'',
                    'address_line_2':'',
                    'address_line_3':''
                }
            }
        },
        mounted() {
            axios.get('/api/user-address/'+localStorage.getItem('user_email')).then((response)=>{
                    if(response.data.status == 'success'){
                       this.addresses = response.data.user.addresses
                       if(this.addresses.length == 0){
                        this.addresses.push(this.default_obj)
                       }
                    }
                })
                .catch((error)=>{
                    toast.fire({
                        'icon': 'error',
                        'title': 'Server Error',
                    });
                });
        },
        methods:{
            add_obj(){
                this.addresses.push(this.default_obj)
            },
            submit_form(){
                let fd = new FormData();
                fd.append('email', localStorage.getItem('user_email'))
                for (let index = 0; index < this.addresses.length; index++) {
                    fd.append('address_line_1['+index+']', this.addresses[index].address_line_1)
                    fd.append('address_line_2['+index+']', this.addresses[index].address_line_2)
                    fd.append('address_line_3['+index+']', this.addresses[index].address_line_3)
                }
                axios.post('/api/address-save',fd).then((response)=>{
                    if(response.data.status == 'success'){
                        toast.fire({
                            'icon': 'success',
                            'title': 'Addresses updated successfully',
                        });
                        this.$router.push('/thank-you')

                    }
                })
                .catch((error)=>{
                    console.log(error.response.data.errors);
                    // this.errors = error.response.data.errors
                    // if(this.errors.length > 0){
                        toast.fire({
                            'icon': 'warning',
                            'title': 'Please fill all fields',
                        });
                    // }
                    
                });
            }
        }
    }
</script>
