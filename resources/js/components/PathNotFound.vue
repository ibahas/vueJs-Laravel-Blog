<template>
  <div class="container">
    <div class="container">
      <div class="row my-4">
        <div class="col-md-8 mt-5">
          <div class="card">
            <div class="card-header">This Page</div>
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
      loading: true,
      id: User.isLogged().id,
    };
  },
  components: {},
  created() {},
  mounted() {},
  methods: {},
};
</script>

<style>
</style>