<template>
    <div class="container">
        <div class="row mt-5 mb-3 mt-6">
            <div class="col-md-12 col-ms-12">
                <div class="bd-example bd-example-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link active"
                                id="home-tab"
                                data-toggle="tab"
                                href="#home"
                                role="tab"
                                aria-controls="home"
                                aria-selected="true"
                                >All users</a
                            >
                        </li>
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link"
                                id="profile-tab"
                                data-toggle="tab"
                                href="#profile"
                                role="tab"
                                aria-controls="profile"
                                aria-selected="false"
                                >Users deleted</a
                            >
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div
                            class="tab-pane fade active show"
                            id="home"
                            role="tabpanel"
                            aria-labelledby="home-tab"
                        >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Email</td>
                                        <td>Is Admin</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(user, index) in users.data"
                                        :key="index"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>
                                            {{
                                                user.admin == 1
                                                    ? "Admin"
                                                    : "User"
                                            }}
                                        </td>
                                        <td>
                                            <a
                                                @click="deleteUser(user.id)"
                                                class="btn btn-danger btn-sm"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <router-link
                                                :to="`/admin/user/${user.id}`"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-info btn-sm"
                                                >
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div
                                class="card-footer d-flex justify-content-center"
                            >
                                <pagination
                                    :data="users"
                                    @pagination-change-page="getUsers"
                                ></pagination>
                            </div>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="profile"
                            role="tabpanel"
                            aria-labelledby="profile-tab"
                        >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Email</td>
                                        <td>Is Admin</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(user,
                                        index) in UsersTrashed.data"
                                        :key="index"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>
                                            {{
                                                user.admin == 1
                                                    ? "Admin"
                                                    : "User"
                                            }}
                                        </td>
                                        <td>
                                            <a
                                                @click="deleteUser(user.id)"
                                                class="btn btn-danger btn-sm"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <button
                                                type="submit"
                                                @click="restore(user.id)"
                                                class="btn btn-info btn-sm"
                                            >
                                                <i class="fa fa-repeat"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div
                                class="card-footer d-flex justify-content-center"
                            >
                                <pagination
                                    :data="UsersTrashed"
                                    @pagination-change-page="getUsersTrashed"
                                ></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import router from "../routes/routes.js";

export default {
    
    metaInfo: {
        title: "Users ",
        titleTemplate: "%s - 2021",
        htmlAttrs: {
            lang: "en",
            amp: true
        }
    },
    data() {
        return {
            users: {},
            loading: true,
            id: User.isLogged().id,
            UsersTrashed: {}
        };
    },
    created() {
        if (User.isLogged().admin == 1) {
            this.getUsers();
            this.getUsersTrashed();
        } else {
            const swalWithBootstrapButtons = Swal.mixin({});
            swalWithBootstrapButtons.fire({
                title: "You don't have any permission  ...",
                icon: "warning",
                showCancelButton: false,
                reverseButtons: false,
                showConfirmButton: false,
                timer: 2500
            });
            router.push({ name: "home" });
        }
    },
    mounted() {},
    methods: {
        getUsers(page) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get("/api/getUsers?page=" + page)
                .then(response => {
                    this.users = response.data;
                })
                .catch(err => console.log(err));
        },
        getUsersTrashed(page) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get("/api/UsersWithTrashed?page=" + page)
                .then(response => {
                    this.UsersTrashed = response.data;
                })
                .catch(err => console.log(err));
        },
        deleteUser(idUser) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                })
                .then(result => {
                    if (result.isConfirmed) {
                        axios
                            .delete("/api/user/" + idUser + "/" + this.id)
                            .then(res => {
                                swalWithBootstrapButtons.fire(
                                    res.data.message,
                                    "success"
                                ),
                                    this.getUsers();
                                this.getUsersTrashed();
                            })
                            .catch(err => console.log(err));
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "Cancelled",
                            "Your artical is safe :)",
                            "error"
                        );
                    }
                });
        },
        restore(id) {
            const config = {
                headers: { "content-type": "multipart/form-data" }
            };
            // console.log(config);
            let formData = new FormData();
            formData.append("id", id);

            axios
                .post("/api/restore/user/" + id, formData, config)
                .then(res => {
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
                        title: res.data.data
                    });
                    this.getUsersTrashed();
                })
                .catch(err => console.log(err));
        }
    }
};
</script>
