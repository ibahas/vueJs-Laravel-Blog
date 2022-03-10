<template>
    <div class="container">
        <div class="row my-4">
            <div class="col-md-4">
                <div class="card h-100 mt-5">
                    <div class="card-header">Author : {{this.author.name}}</div>
                    <div class="card-body">
                         <span class="text-default text-dark">
                          Type User is :  {{ this.author.typeUser == 0 ? 'User' : 'Admin' }}
                        </span>
                        <hr />
                        <div class="media">
                            <div class="media-body">
                                <p class="lead text-dark">Email Author : <span class="lead text-danger">{{this.author.email}}</span></p>
                            </div>
                        </div>
                        <div class="media">
                             <div class="text-success">Count posts<span class="text-dark"> {{this.author.countPosts}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-5 col-ms-12">
                <div class="card h-100">
                    <div class="card-header">Articles</div>
                    <div
                        class="card-body"
                        v-for="(post, index) in posts"
                        :key="index"
                    >
                        <hr />
                        <router-link :to="`${post.path}`">
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
                                            {{ post.user }}
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
export default {
    data() {
        return {
            posts: {},
            author: {}
        };
    },
    created() {
        this.getPosts();
        this.getInfoAuthor();
    },
    methods: {
        getPosts() {
            var $url = `/api/posts/author/${this.$route.params.id}`;
            User.checkUel($url);
            axios
                .get(`/api/posts/author/${this.$route.params.id}`)
                .then(response => {
                    this.posts = response.data;
                })
                .catch(err => console.log(err));
        },
        getInfoAuthor(e) {
            axios
                .get("/api/userInfo/" + this.$route.params.id)
                .then(res => {
                    this.author = res.data;
                })
                .catch(err => console.log(err));
        }
    },
    watch: {
        $route: "getPosts"
    }
};
</script>
