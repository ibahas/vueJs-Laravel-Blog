
<template>
  <div>
    <Navbar />
    <router-view></router-view>
  </div>
</template>


<script>
import Navbar from "./Navbar.vue";

export default {
  components: {
    Navbar,
  },
  metaInfo: {
    title: "Site Blog ",
    titleTemplate: "%s - 2021",
    htmlAttrs: {
      lang: "en",
      amp: true,
    },
  },
};
</script>
