<template>
    <div class="container">
        <div class="row my-4">
            <div class="col-md-8 mx-auto mt-5">
                <div class="card p-5">
                    <form
                        v-on:submit="updateUser"
                        v-on:submit.prevent
                        enctype="multipart/form-data"
                    >
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="Name"
                                v-model="user.name"
                                aria-describedby="Name"
                                placeholder="Enter name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"
                                >Email address</label
                            >
                            <input
                                type="email"
                                v-model="user.email"
                                class="form-control"
                                id="exampleInputEmail1"
                                aria-describedby="emailHelp"
                                placeholder="Enter email"
                            />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                v-model="user.password"
                                id="exampleInputPassword1"
                                placeholder="Password"
                            />
                        </div>
                        <div class="clearflix">
                            <div class="float-right">
                                <button
                                    type="button"
                                    class="btn btn-info"
                                    @click="updateUser"
                                >
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    metaInfo: {
        title: "Edit User ",
        titleTemplate: "%s - 2023",
        htmlAttrs: {
            lang: "en",
            amp: true
        }
    },
    data() {
        return {
            user: {
                id: "",
                name: "",
                email: "",
                admin: ""
            },
            name: "",
            email: "",
            password: "",
            deleted_at: ""
        };
    },
    computed: {},

    methods: {
        updateUser(e) {
            e.preventDefault();
            const config = {
                headers: { "content-type": "multipart/form-data" }
            };
            // console.log(config);
            let formData = new FormData();
            formData.append("name", this.user.name);
            formData.append("email", this.user.email);
            formData.append("password", this.user.password);
            formData.append("id", this.user.id);

            axios
                .post("/api/editUser/" + this.user.id, formData, config)
                .then(res => {
                    if (res.data.data == "User updated successfully.") {
                        Swal.fire({
                            icon: "success",
                            title: res.data.data,
                            text: "Something went wrong!",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        this.$router.back();
                    }
                })
                .catch(err => console.log(err));
        }
    },

    created() {
        var $url = `/api/user/${this.$route.params.id}`;
        User.checkUel($url);
        axios
            .get(`/api/user/${this.$route.params.id}`)
            .then(response => {
                this.user = response.data;
                document.title = this.user.name + " || App";
            })
            .catch(err => console.log(err));
    }
};
</script>
