<template>
<div class="container">
    <div class="row mt-5 mb-3">
        <button data-target="#addPosts" data-toggle="modal" class="btn btn-sm btn-success text-white mb-2 pt-2">
            <i class="fa fa-plus"></i>
        </button>
        <div class="col-md-12 col-ms-12">
            <table class="table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Catogry</td>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Image</td>
                        <td>By</td>
                        <td>Le</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(post, index) in posts.data" :key="index">
                        <td>{{ post.id }}</td>
                        <td>{{ post.category.substr(0, 10) }}</td>
                        <td>{{ post.title.substr(0, 10) }}</td>
                        <td class="lead">{{ post.body.substr(0, 50) }}</td>
                        <td>
                            <img :src="post.photo" height="100" class="img-fluid mr-2 rounded shadow-sm" width="100" />
                        </td>
                        <td>{{ post.user.name }}</td>
                        <td>{{ post.added }}</td>
                        <td>
                            <router-link :to="{path : 'post/edit/' + post.slug}" class="btn btn-info btn-sm mb-2">
                                <i class="fa fa-edit"></i>
                            </router-link>
                            <br />
                            <router-link :to="post.path" class="btn btn-success btn-sm mb-2">
                                <i class="fa fa-eye"></i>
                            </router-link>
                            <br />
                            <a @click="deletePost(post.slug)" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <AddPost @added="postAdded" />
            <div class="card-footer d-flex justify-content-center">
                <pagination :data="posts" @pagination-change-page="getPosts"></pagination>
            </div>
        </div>
    </div>
</div>

</template>

<script>
import AddPost from "./addPost";

export default {
  data() {
    return {
      posts: {},
      loading: true,
      id: User.isLogged().id,
    };
  },
  components: { AddPost },
  created(){
    if(User.isLogged().admin == 1){
      this.getPosts();
    }else{
      this.$route.push({name : "home"});
    }
  },
  mounted() {
  },
  methods: {
    getPosts(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      axios
        .get("/api/posts?page=" + page)
        .then((response) => {
          this.posts = response.data;
        })
        .catch((err) => console.log(err));
    },
    postAdded() {
      this.getPosts();
    },
    deletePost(slug){
       const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete('api/posts/' + slug).then(res => {
          
            swalWithBootstrapButtons.fire(
              'Deleted!',
              res.data.message,
              'success'
            ),
            this.getPosts();
          }).catch(err => console.log(err));
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your artical is safe :)',
            'error'
          )
        }
      })


    }
  },
};
</script>

<style>
</style>