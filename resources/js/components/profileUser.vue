<template>
    <div class="container">
        <div class="">
            <div class="page-content page-container" id="page-content">
                <div class="padding">
                    <div
                        class="row container  justify-content-center"
                        style="margin-top:20rem"
                    >
                        <div class="col-xl-6 col-md-12">
                            <div class="card user-card-full">
                                <div class="row m-l-0 m-r-0">
                                    <div
                                        class="col-sm-4 bg-c-lite-green user-profile"
                                    >
                                        <div
                                            class="card-block text-center text-white"
                                        >
                                            <div class="m-b-25">
                                                <img
                                                    style="width: 100%; height:90px; margin-top : 1rem"
                                                    src="https://ibahas.ddns.net/storage/2.png"
                                                    class="img-radius"
                                                    alt="User-Profile-Image"
                                                />
                                            </div>
                                            <h6 class="f-w-600">
                                                Hembo Tingor
                                            </h6>
                                            <p>Web Designer</p>
                                            <i
                                                class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="card-block ">
                                            <h6
                                                class="m-b-20 p-b-5 b-b-default f-w-600 mt-2"
                                            >
                                                Information
                                            </h6>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">
                                                        Email
                                                    </p>
                                                    <h6
                                                        class="text-muted f-w-400"
                                                    >
                                                        {{ user.email }}
                                                    </h6>
                                                </div>
                                                <div class="col-sm-6"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">
                                                        Name
                                                    </p>
                                                    <h6
                                                        class="text-muted f-w-400"
                                                    >
                                                        {{ user.name }}
                                                    </h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">
                                                        Type Account :
                                                    </p>
                                                    <h6
                                                        class="text-muted f-w-400"
                                                        v-if="user.admin == 1"
                                                    >
                                                        Admin
                                                    </h6>
                                                    <h6
                                                        class="text-muted f-w-400"
                                                        v-else
                                                    >
                                                        User
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="card">
                                    <div class="card-title f-900 text-center">
                                        Change Password :
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input
                                                type="password"
                                                placeholder="Password"
                                                v-model="password"
                                                class="form-control"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <input
                                                type="password"
                                                placeholder="Confirm Password"
                                                v-model="cPassword"
                                                class="form-control"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <button
                                                class="btn btn-primary"
                                                @click="login"
                                                :disabled="password.length == 0"
                                            >
                                                update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: User.getUser(),
            password: "",
            cPassword: ""
        };
    },
    components: {},
    created() {},
    methods: {
        login() {
            axios
                .post("/api/changePassword", {
                    password: this.password,
                    cPassword: this.cPassword,
                    id: this.user.id
                })
                .then(response => {
                    if (
                        response.data.data ==
                        "Your password has been updated successfully"
                    ) {
                        this.cPassword = "";
                        this.password = "";
                        Swal.fire({
                            icon: "success",
                            title: response.data.data,
                            text: "Done!",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        if (response.data.password != "") {
                            Swal.fire({
                                icon: "error",
                                title: response.data.data.password,
                                text: "Something went wrong!",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: response.data.data,
                                text: "Something went wrong!",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    }
                })
                .catch(err => console.log(err));
        }
    }
};
</script>
