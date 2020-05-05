<template>
	<div id="welcome-box">
		<div class="title m-b-md font-weight-bold">
			Welcome!
		</div>
		<div class="h2 mb-3 font-weight-bold">
			What would you like to see today?
		</div>
		<form @submit.prevent="handleSubmit">
			<div class="form-group mb-2 d-flex justify-content-center">
				<input class="form-control w-50" type="text" name="image_topic" id="image_topic" v-model="search_term" />
			</div>
			<div><button type="button" class="btn btn-primary" @click="handleSubmit">Submit</button></div>
		</form>
	</div>
</template>

<script>
export default {
	data() {
		return {
			search_term: ""
		};
	},
	methods: {
		handleSubmit() {
			this.$emit('fetchImages', this.search_term)
		}
	}
};
</script>

<style></style>
