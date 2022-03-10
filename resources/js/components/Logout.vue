<template>
    <div>

    </div>
</template>


<script>
export default {
    mounted () {
        User.logout();
        this.$router.push({name : 'home'});
    }
}
</script>
