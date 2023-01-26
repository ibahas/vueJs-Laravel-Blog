<template>
    <div class="container">
        <div class="col-md-6 mx-auto py-5 mt-5">
            <div class="card my-5">
                <div class="card-header">
                    Registration
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input
                            type="text"
                            placeholder="Full Name"
                            v-model="name"
                            class="form-control"
                        />
                    </div>
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
                        />
                    </div>
                    <div class="form-group">
                        <button
                            class="btn btn-primary"
                            @click="register"
                            :disabled="
                                password.length == 0 &&
                                    name.length == 0 &&
                                    email.length == 0
                            "
                        >
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
    metaInfo: {
        title: "Register ",
        titleTemplate: "%s - 2023",
        htmlAttrs: {
            lang: "en",
            amp: true
        }
    },
    data() {
        return {
            name: "",
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
        register() {
            var $url = `/api/users/register/*`;
            User.checkUel($url);

            if (this.password.length >= 8) {
                axios
                    .post("/api/users/register", {
                        name: this.name,
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        if (response.data.logged == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "All fields is required. <br/> ",
                                footer: "Check Email Or Password",
                                text: "Something went wrong!",
                                timer: 3000,
                                showConfirmButton: false
                            });
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: toast => {
                                    toast.addEventListener(
                                        "mouseenter",
                                        Swal.stopTimer
                                    );
                                    toast.addEventListener(
                                        "mouseleave",
                                        Swal.resumeTimer
                                    );
                                }
                            });

                            Toast.fire({
                                icon: "success",
                                title: "Registered in successfully"
                            });
                            User.storeUser(JSON.stringify(response.data));
                            this.$router.go();
                        }
                    })
                    .catch(err => console.log(err));
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: toast => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: "success",
                    title: "Check Password"
                });
            }
        }
    }
};
</script>
