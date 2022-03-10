<style scoped>
.router-link-exact-active {
    color: black !important;
}
</style>
<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <router-link class="navbar-brand" :to="home">Blog</router-link>
            <button
                class="navbar-toggler hidden-lg-up "
                type="button"
                data-toggle="collapse"
                data-target="#collapsibleNavId"
                aria-controls="collapsibleNavId"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item ">
                        <router-link class="nav-link" :to="home"
                            >Home</router-link
                        >
                    </li>
                    <li class="nav-item ">
                        <router-link
                            class="nav-link"
                            :to="signup"
                            v-if="!logged"
                            >Register</router-link
                        >
                    </li>

                    <li class="nav-item ">
                        <router-link
                            class="nav-link"
                            :to="adminPanel"
                            v-if="this.admin == 1"
                            >Admin Panel</router-link
                        >
                    </li>
                    <li class="nav-item ">
                        <router-link
                            class="nav-link"
                            :to="users"
                            v-if="this.admin == 1"
                            >Admin Users</router-link
                        >
                    </li>
                </ul>
                <div class="float-right ">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                @click="userlogout"
                                style="cursor: pointer;"
                                v-if="logged"
                                >Logout</a
                            >
                        </li>
                        <li class="nav-item ">
                            <router-link
                                class="nav-link"
                                :to="profileUser"
                                v-if="logged"
                                >My Account ||
                                <span class="font-weight-bold">{{
                                    name.toUpperCase()
                                }}</span></router-link
                            >
                        </li>
                        <li class="nav-item ">
                            <router-link
                                class="nav-link"
                                :to="login"
                                v-if="!logged"
                                >Login</router-link
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    data() {
        return {
            home: "/",
            login: "/login",
            signup: "/signup",
            logout: "/logout",
            logged: User.isLogged().logged,
            name: User.isLogged().name,
            adminPanel: "/admin",
            admin: User.isLogged().admin,
            profileUser: "/profile",
            users: "/admin/users",
            thisRoute: ""
        };
    },
    created() {
        this.thisRoute = this.$router.currentRoute.name;
    },
    methods: {
        userlogout() {
            User.logout();
            this.logged = false;
            this.$router.go();
        }
    }
};
</script>
