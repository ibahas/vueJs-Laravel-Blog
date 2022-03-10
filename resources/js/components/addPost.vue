<template>
    <div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="addPosts"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addPost"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title"><h1>Add new post</h1></div>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form
                            @click="getCate()"
                            v-on:submit="AddProstsss"
                            v-on:submit.prevent
                            enctype="multipart/form-data"
                        >
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select
                                    v-model="category"
                                    name="category"
                                    id="category"
                                    class="form-control"
                                    required
                                >
                                    <option selected disabled
                                        >Select Category</option
                                    >
                                    <option
                                        :value="category.id"
                                        v-for="(category, index) in categories"
                                        :key="index"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input
                                    v-model="title"
                                    type="text"
                                    name="title"
                                    id="title"
                                    required
                                    class="form-control"
                                />
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea
                                    v-model="body"
                                    name="body"
                                    id="body"
                                    required
                                    class="form-control"
                                    rows="5"
                                    placeholder="Discription"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input
                                    type="file"
                                    v-on:change="onImageChange"
                                    name="image"
                                    id="photo"
                                />
                                <img
                                    :src="avatar"
                                    width="450"
                                    height="300"
                                    class="mt-2 mb-2"
                                    alt="Image"
                                />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="submit"
                            @click="AddProstsss"
                            class="btn btn-primary"
                        >
                            Submit
                        </button>
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
            avatar: null,
            title: "",
            body: "",
            category: "",
            categories: [],
            image: null
        };
    },
    created() {
        this.getCate();
    },
    methods: {
        getCate() {
            axios
                .get("/api/all/categories")
                .then(response => {
                    this.categories = response.data.categories;
                })
                .catch(err => console.log(err));
        },
        onImageChange(e) {
            let image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
                //  console.log(e);
                this.avatar = e.target.result;
            };
        },
        AddProstsss(e) {
            e.preventDefault();
            const config = {
                headers: { "content-type": "multipart/form-data" }
            };
            // console.log(config);
            let formData = new FormData();
            formData.append("image", this.avatar);
            formData.append("title", this.title);
            formData.append("body", this.body);
            formData.append("category_id", this.category);
            formData.append("user_id", User.isLogged().id);
            if (this.title == "" || this.body == "" || this.category == "") {
                Swal.fire({
                    icon: "error",
                    title: "All fields are required",
                    text: "Something went wrong!",
                    timer: 1500,
                    showConfirmButton: false
                });
            }
            axios
                .post("api/posts", formData, config)
                .then(res => {
                    $("#addPosts").modal("hide");
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: res.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.title = "";
                    this.body = "";
                    this.category = "";
                    this.image = null;
                    this.avatar = null;
                    this.$emit("added");
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style></style>
