<template>
   <div class="container">
    <div class="row my-4">
        <Categories></Categories>
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header">Articles</div>

                <div class="card-body" v-for="(post,index) in posts" :key="index">
                    <div class="media">
                        <img :src="post.photo" class="rounded shadow-sm img-fluid mr-2" alt="" srcset="" />
                        <div class="media-body">
                            <router-link :to="post.path">
                                <h3>{{post.title}}</h3>
                            </router-link>
                            <p>
                                <span class="text-default">
                                    {{post.user.name}}
                                </span>
                                <span class="text-danger">
                                    {{post.added}}
                                </span>
                            </p>
                            <p class="lead">{{post.body.substr(0,200)}}...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
    import Categories from './Categories.vue';

    export default {
        data(){
            return{
                posts : {}
            }
        },
        components : {
            Categories
        },
        created () {
            this.getPosts();
        },
        methods: {
            getPosts(){
                axios.get(`/api/posts/category/${this.$route.params.slug}`)
                    .then(response => {
                        console.log(response.data);
                        this.posts = response.data;
                    })
                    .catch(err => console.log(err));
            }
        },
        watch: {
            '$route' : 'getPosts'
        },
    }
</script>
