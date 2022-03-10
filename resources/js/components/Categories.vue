<style scoped>
.list-group-item {
    position: relative;
}
.router-link-exact-active::before {
    content: "";
    width: 100%;
    height: 100%;
    position: absolute;
    background: #fbbc05;
    opacity: 0.3;
    z-index: 1;
    top: 0;
    left: 0;
    background: #ffbf00;
}
.router-link-exact-active::after {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 3;
    overflow: hidden;
    font-size: 2em;
    color: #4285f4;
    text-align: center;
    text-shadow: 0px 0px 5px #fbbc05;
    background: #fbbc05;
    padding: 5px;
    animation-name: blinking;
    animation-duration: 1s;
    animation-iteration-count: infinite;
    animation-direction: alternate;
}
@keyframes blinking {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}
</style>
<template>
    <div class="col-md-4 mt-5">
        <div class="card">
            <h2 class="card-header">Categories</h2>
            <div class="card-body">
                <ul class="list-group">
                    <li
                        class="list-group-item"
                        v-for="(category, index) in categories"
                        :key="index"
                    >
                        <router-link :to="`/posts/category/${category.slug}`">
                            {{ category.name }}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            categories: []
        };
    },
    created() {
        axios
            .get("/api/categories")
            .then(response => (this.categories = response.data.categories))
            .catch(err => console.log(err));
    }
};
</script>
