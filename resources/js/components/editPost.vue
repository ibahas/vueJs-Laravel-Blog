<template>
  <!-- Modal -->
<div class="row mt-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-title text-center">
                Update Post : {{ post.title }}
            </div>
            <div class="modal-body">
                <form v-on:submit="updatePost" v-on:submit.prevent enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select v-model="selectedValue" name="category" id="category" class="form-control" required>
                            <option selected disabled>Select Category</option>
                            <option :value="category.id" v-for="(category, index) in categories" :key="index">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input v-model="post.title" type="text" name="title" id="title" required class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea v-model="post.body" name="body" id="body" required class="form-control" rows="5" placeholder="Discription"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input v-on:click="seen = false" type="file"   v-on:change="onImageChange" name="image" id="photo" />
                        <img v-if="seen" id="hide" :src="post.photo" width="450" height="300" class="mt-2 mb-2" alt="Image" />
                        <img :src="avatar" width="450" height="300" class="mt-2 mb-2" alt="Image" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" @click="updatePost" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      avatar: "",
      post: { title: "", body: "", category: "" , slug:"",photo:""},
      categories: [],
      image: null,
      selectedValue: '',
      seen: true,
    };
  },
  created() {
    this.getCategories();
    this.getPost();
    this.avatar = this.post.photo;
    console.log(this.post.photo);
  },
  methods: {
    onImageChange(e) {
      let image = e.target.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        //  console.log(e.target.result);
        this.avatar = e.target.result;
      };
    },
    getCategories() {
      axios
        .get("/api/all/categories")
        .then((response) => {
          this.categories = response.data.categories;
        })
        .catch((err) => console.log(err));
    },
    getPost() {
      axios
        .get("/api/posts/" + this.$route.params.slug)
        .then((res) => {
          //  console.log(res);
          this.post = res.data;
              this.selectedValue = this.post.category_id;
          // console.log(this.selectedValue);
          // console.log(this.post);
          // console.log(this.post.slug);
        })
        .catch((err) => console.log(err));
    },
    updatePost(e) {
      e.preventDefault();
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      // console.log(config);
      let formData = new FormData();
      formData.append("image", this.avatar);
      formData.append("title", this.post.title);
      formData.append("body", this.post.body);
      formData.append("category_id", this.post.category_id);
      formData.append("user_id", User.isLogged().id);
      formData.append("_method", "put");

      axios
        .post("/api/posts/" + this.post.slug , formData, config)
        .then((res) => {
          console.log(res);
              Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: res.data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
           this.$router.back();
        })
        .catch((err) => console.log(err));
    },
    onChange: function (event) {
      console.log(this.selectedValue);
    },
  },
};
</script>

<style></style>
