<template>
    <div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="addCategory"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addCategory"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title"><h1>Add new category</h1></div>

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
                            v-on:submit="AddProstsss"
                            v-on:submit.prevent
                            enctype="multipart/form-data"
                        >
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input
                                    v-model="name"
                                    type="text"
                                    name="title"
                                    id="title"
                                    required
                                    class="form-control"
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
                            @click="AddProstsss"
                            type="submit"
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
            name: ""
        };
    },
    created() {},
    methods: {
        AddProstsss(e) {
            e.preventDefault();
            const config = {
                headers: { "content-type": "multipart/form-data" }
            };
            // console.log(config);
            let formData = new FormData();
            formData.append("name", this.name);
            if (this.name == "") {
                Swal.fire({
                    icon: "error",
                    title: "All fields are required",
                    text: "Something went wrong!",
                    timer: 1500,
                    showConfirmButton: false
                });
            }
            axios
                .post("/api/categories", formData, config)
                .then(res => {
                    $("#addCategory").modal("hide");
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: res.data.data,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.name = "";
                    this.$emit("addedCate");
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style></style>
