<template>
   <div class="container">
    <div class="col-md-6 mx-auto py-5 mt-5">
        <div class="card my-5">
            <div class="card-header">
                Registration
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input type="text" placeholder="Full Name" v-model="name" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="email" required placeholder="Email" v-model="email" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" v-model="password" class="form-control" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"
                     @click="register" :disabled="password.length == 0 && name.length == 0 && email.length == 0">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</template>


<script>
export default {
    data(){
        return{
            name : '',
            email : '',
            password : ''
        }
    },
    created () {
        if(User.isLogged()){
            this.$router.push({name : 'home'});
        }
    },
    methods: {
        register(){
            axios.post('/api/users/register',{
                name : this.name,
                email : this.email,
                password : this.password
            }).then(response => {
                console.log(response.data);
                User.storeUser(JSON.stringify(response.data));
                this.$router.go();
            }).catch(err => console.log(err));
        }
    },
}
</script>
