<template>
    <div class="container">
        <div class="row my-4">
            <Categories></Categories>
            <div class="col-md-8 mt-5 col-ms-12">
                <div class="card h-100">
                    <div class="card-header">Articles</div>

                    <div
                        class="card-body"
                        v-for="(post, index) in posts"
                        :key="index"
                    >
                        <hr />
                        <router-link :to="post.path">
                            <div class="media">
                                <img
                                    :src="post.photo"
                                    class="rounded shadow-sm img-fluid mr-2"
                                    alt=""
                                    srcset=""
                                    height="200"
                                    width="200"
                                />
                                <div class="media-body">
                                    <h3 class="text-dark">{{ post.title }}</h3>

                                    <p>
                                        <span class="text-default text-dark">
                                            {{ post.user.name }}
                                        </span>
                                        <span class="text-danger">
                                            {{ post.added }}
                                        </span>
                                    </p>
                                    <p class="lead text-dark">
                                        {{ post.body.substr(0, 200) }}...
                                    </p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Categories from "./Categories.vue";

export default {
    data() {
        return {
            posts: {}
        };
    },
    components: {
        Categories
    },
    created() {
        this.getPosts();
        this.getTitle();
    },
    methods: {
        getPosts() {
            var $url = `/api/posts/category/${this.$route.params.slug}`;
            User.checkUel($url);
            axios
                .get(`/api/posts/category/${this.$route.params.slug}`)
                .then(response => {
                    this.posts = response.data;
                })
                .catch(err => console.log(err));
        },
        getTitle() {
            axios
                .get(`/api/categories/${this.$route.params.slug}`)
                .then(response => {
                    this.title = response.data.name;
                    document.title = "Category " + this.title + " || App";
                })
                .catch(err => console.log(err));
        }
    },
    watch: {
        $route: "getPosts"
    }
};
</script>
