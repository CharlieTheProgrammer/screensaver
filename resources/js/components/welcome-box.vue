<template>
	<div id="welcome-box">
		<div class="title m-b-md font-weight-bold">
			Welcome User
		</div>
		<div class="h2 mb-3 font-weight-bold">
			What would you like to see today?
		</div>
		<form method="POST" action="/">
			<input id="csrf-token" name="_token" type="hidden" :value="csrf_token" />
			<div class="form-group mb-2 d-flex justify-content-center">
				<input class="form-control w-50" type="text" name="image_topic" id="image_topic" />
			</div>
			<div><button class="btn btn-primary">Submit</button></div>
		</form>
	</div>
</template>

<script>
export default {
	data() {
		return {
			csrf_token: db.get("csrf")
		};
	}
};
</script>

<style></style>
