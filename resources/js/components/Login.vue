<template>
    <div class="container">
        <div class="col-md-6 mx-auto py-5 mt-5">
            <div class="card my-5">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input
                            type="email"
                            required
                            placeholder="Email"
                            v-model="email"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <input
                            type="password"
                            placeholder="Password"
                            v-model="password"
                            class="form-control"
                            min="8"
                        />
                    </div>
                    <div class="form-group">
                        <button
                            class="btn btn-primary"
                            @click="login"
                            :disabled="
                                password.length == 0 && email.length == 0
                            "
                        >
                            Login
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
     metaInfo: {
        title: "Login ",
        titleTemplate: "%s - 2023",
        htmlAttrs: {
            lang: "en",
            amp: true
        }
    },
    data() {
        return {
            email: "",
            password: ""
        };
    },
    created() {
        if (User.isLogged()) {
            this.$router.push({ name: "home" });
        }
    },
    methods: {
        login() {
            axios
                .post("/api/users/login", {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    if (response.data.error == "Email or password is incorrect") {
                        Swal.fire({
                            icon: "error",
                            title: response.data.error,
                            text: "Something went wrong!",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        User.storeUser(JSON.stringify(response.data));
                        this.$router.go();
                        
                    }
                })
                .catch(err => console.log(err));
        }
    }
};
</script>
