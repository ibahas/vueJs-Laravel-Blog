<template>
 <div class="container">
    <div class="row my-4">
        <Categories></Categories>
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header">Articles</div>

                <div class="card-body" v-for="(post, index) in posts.data" :key="index">
                    <div class="media">
                        <img :src="post.photo" class="rounded shadow-sm img-fluid mr-2" alt="" srcset="" height="200" width="200" />
                        <div class="media-body">
                            <router-link :to="post.path">
                                <h3>{{ post.title }}</h3>
                            </router-link>
                            <p>
                                <span class="text-default">
                                    {{ post.user.name }}
                                </span>
                                <span class="text-danger">
                                    {{ post.added }}
                                </span>
                            </p>
                            <p class="lead">{{ post.body.substr(0, 200) }}...</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <pagination :data="posts" @pagination-change-page="getPosts"></pagination>
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
      posts: {},
    };
  },
  components: {
    Categories,
  },
  created() {
    this.getPosts();
  },
  methods: {
    getPosts(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      axios
        .get("/api/posts?page=" + page)
        .then((response) => {
          console.log(response.data);
          this.posts = response.data;
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
