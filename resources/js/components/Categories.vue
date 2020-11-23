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
      categories: [],
    };
  },
  created() {
    axios
      .get("/api/categories")
      .then((response) => (this.categories = response.data.categories))
      .catch((err) => console.log(err));
  },
};
</script>
