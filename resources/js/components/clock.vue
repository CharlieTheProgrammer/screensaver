<template>
  <div id="clock" class="display-1">
      {{ date | toTimeFormat }}
  </div>
</template>

<script>
export default {
    data() {
        return {
            date: {}
        }
    },
    created() {
        this.date = new Date();
        setInterval(()=>{
            this.date = new Date();
        }, 300);
    },
    filters: {
        toTimeFormat(date) {
            const time = date.toLocaleTimeString();
            return  time.substring(0, time.lastIndexOf(':')) +  time.substring(time.lastIndexOf(':') + 3);
        }
    }
}
</script>

<style>

</style>