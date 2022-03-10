<style scoped>
.customeX {
    position: absolute;
    right: 10%;
}
</style>
<template>
    <div class="container">
        <div class="row my-4">
            <div class="col-md-8 mx-auto mt-5">
                <div class="card">
                    <h2 class="card-header">{{ post.title }}</h2>
                    <p class="p-4">
                        <span class="badge badge-danger">
                            {{ post.user }}
                        </span>
                        <span class="badge badge-info">
                            {{ post.created_at }}
                        </span>
                        <span class="badge badge-success">
                            <router-link
                                :to="`/posts/category/${this.categorySlug}`"
                                class="text-white"
                            >
                                {{ post.category }}
                            </router-link>
                        </span>
                    </p>
                    <div class="card-img-top">
                        <img
                            style="width: 100%; height: 400px"
                            height="400"
                            :src="post.photo"
                            class="rounded shadow-sm img-fluid mr-2"
                            alt=""
                            srcset=""
                        />
                    </div>
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p
                                    @click="readMorePost()"
                                    class="lead substring"
                                >
                                    {{ post.body.substring(0, 15) + " ..." }}
                                </p>
                                <p
                                    @click="readLessPost()"
                                    class="lead allPost"
                                    style="display: none"
                                >
                                    {{ post.body }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-12">
                        <div class="media shadow my-4 p-4" v-if="logged">
                            <div class="media-body">
                                <h3 class="my-3 text-dark">Add a comment</h3>
                                <div class="form-group">
                                    <label for="">comment</label>
                                    <textarea
                                        class="form-control"
                                        col="30"
                                        rows="3"
                                        v-model="comment"
                                    ></textarea>
                                </div>
                                <button
                                    type="button"
                                    name=""
                                    id=""
                                    class="btn btn-primary"
                                    @click="addComment(post.id)"
                                    :disabled="isDisabledComment"
                                >
                                    Add
                                </button>
                                <br />
                            </div>
                        </div>
                        <div class="media my-4 shadow p-4" v-else>
                            <div class="media-body">
                                <router-link to="/login"
                                    >Log in to comment</router-link
                                >
                            </div>
                        </div>
                        <h3 class="text-info mb-3">
                            Comments
                            <span class="badge badge-dark p-4">
                                {{ post.comments_count }}
                            </span>
                        </h3>
                        <div
                            class="media my-4 p-4 shadow"
                            v-for="(commentLoop, index) in post.comments"
                            :key="index"
                        >
                            <div class="media-body">
                                <div v-if="getUser.admin == 1">
                                    <div class="customeX">
                                        <button
                                            @click="
                                                deleteComment(commentLoop.id)
                                            "
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="text-danger">
                                    {{ commentLoop.user }} |
                                    {{ commentLoop.created_at }}
                                    <span
                                        class="btn btn-sm text-dark"
                                        aria-disabled="true"
                                    >
                                        | Count reply ->
                                        <span
                                            class="badge badge-dark"
                                            v-bind:class="
                                                'repliesCount' + commentLoop.id
                                            "
                                        >
                                            {{
                                                commentLoop.repliesCount > 0
                                                    ? commentLoop.repliesCount
                                                    : 0
                                            }}
                                        </span>
                                    </span>
                                </span>
                                <p class="lead text-center ">
                                    {{ commentLoop.body }}
                                </p>

                                <div
                                    style="display: none"
                                    class="media-body ReplyArea"
                                    v-bind:class="'ReplyArea_' + commentLoop.id"
                                >
                                    <h3 class="my-3 text-dark">Add a reply</h3>
                                    <div class="form-group">
                                        <label for="">Reply</label>
                                        <textarea
                                            class="form-control"
                                            col="30"
                                            rows="3"
                                            v-model="reply"
                                        ></textarea>
                                    </div>
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        @click="addReply(commentLoop.id)"
                                        :disabled="isDisabledReply"
                                    >
                                        Add
                                    </button>
                                </div>
                                <br />
                                <button
                                    class="btn btn-info replyAreaId"
                                    v-bind:id="'ReplyArea_' + commentLoop.id"
                                    v-on:click="displaynumbers"
                                >
                                    {{ btnReply }}
                                </button>
                                <div
                                    class="media my-4 p-4 shadow"
                                    v-for="(repli,
                                    index) in commentLoop.replies"
                                    :key="index"
                                >
                                    <div v-if="getUser.admin == 1">
                                        <div class="customeX">
                                            <button
                                                @click="deleteReply(repli.id)"
                                                type="button"
                                                class="btn btn-danger btn-sm"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="">
                                        <p class="text-success">
                                            {{ repli.user }} |
                                            {{ repli.created_at }}
                                        </p>
                                        <span class="lead text-center">
                                            {{ repli.replyComment }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            post: {
                id: "",
                title: "",
                body: "",
                slug: "",
                category_id: "",
                user_id: "",
                comments: "",
                repliesCount: "",
                half: "",
                replies: ""
            },
            categorySlug: "",
            comment: "",
            logged: User.isLogged().logged,
            idPost: "",
            reply: "",
            btnReply: "Reply",
            getUser: User.getUser()
        };
    },
    computed: {
        isDisabledComment() {
            if (this.comment >= 0) {
                this.getCategory();
                return true;
            } else {
                return false;
            }
        },
        isDisabledReply() {
            // you can  check your form is filled or not here.
            if (this.reply >= 0) {
                return true;
            } else {
                return false;
            }
        }
    },

    methods: {
        deleteComment(id) {
            console.log(id);
            axios
                .delete("/api/comments/" + id)
                .then(res => {
                    Swal.fire({
                        icon: "success",
                        title: res.data.data,
                        text: "comment deleted successfuly!",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    this.getPost();
                })
                .catch(err => console.log(err));
        },
        deleteReply(id) {
            console.log(id);
            axios
                .delete("/api/reply_comments/" + id)
                .then(res => {
                    Swal.fire({
                        icon: "success",
                        title: res.data.data,
                        text: "relpy deleted successfuly!",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    this.getPost();
                })
                .catch(err => console.log(err));
        },
        getPost() {
            var $url = `/api/posts/${this.$route.params.slug}`;
            User.checkUel($url);
            axios
                .get(`/api/posts/${this.$route.params.slug}`)
                .then(response => {
                    this.post = response.data;
                    document.title = this.post.title + "|| App";
                })
                .catch(err => console.log(err));
        },
        getCategory(id) {
            axios
                .get("/api/category/" + this.post.category_id)
                .then(res => {
                    this.categorySlug = res.data.data.slug;
                })
                .catch(err => console.log(err));
        },
        addComment(id) {
            axios
                .post("/api/comments", {
                    post_id: id,
                    body: this.comment,
                    user_id: User.isLogged().id
                })
                .then(response => {
                    this.post.comments_count += 1;
                    this.post.comments.unshift(response.data);
                    this.comment = null;
                })
                .catch(err => console.log(err));
        },
        addReply(id) {
            axios
                .post("/api/reply", {
                    comments: id,
                    reply: this.reply,
                    user: User.isLogged().id
                })
                .then(response => {
                    var oldNumber = $(".repliesCount" + id).text();
                    $(".repliesCount" + id).text(++oldNumber);
                    this.reply = "";
                    Swal.fire({
                        icon: "success",
                        title: "Reply Added",
                        text: "your relpy added successfuly!",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    this.getPost();
                })

                .catch(err => console.log(err));
        },

        displaynumbers: function(e) {
            // some code to filter users
            const thisElementId = e.target.id;
            $("." + thisElementId).toggle();

            if ($("." + thisElementId).is(":visible")) {
                $("#" + thisElementId).text("Close");
                $(".ReplyArea").each(function(index, element) {
                    $(this).hide();
                });
                $(".replyAreaId").each(function(index, element) {
                    $(this).text("Reply");
                });
                $("." + thisElementId).toggle();
                $("#" + thisElementId).text("Close");
            } else {
                this.reply = "";
                $("#" + thisElementId).text("Reply");
            }
        },
        readMorePost: function(e) {
            $(".substring").hide();
            $(".allPost").show();
        },
        readLessPost: function(e) {
            $(".substring").show();
            $(".allPost").hide();
        }
    },

    created() {
        this.getPost();
    }
};
</script>
