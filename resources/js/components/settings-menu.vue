<template>
	<!-- Modal -->
	<div class="modal fade" id="settings-menu" tabindex="-1" role="dialog" aria-labelledby="settings-menu-title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content glass glass-font">
				<div class="modal-header d-none">
					<h5 class="modal-title" id="settings-menu-title">
						Settings
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="mb-4">
						<h1>General</h1>
						<p class="text-muted h5 font-weight-bold">Customize Your Dashboard</p>
					</div>
					<div>
						<h2>Show</h2>
						<div class="container-fluid">
							<div class="row justify-content-between align-items-center border-top border-bottom cursor-on-hover px-2" >
								<div class="font-weight-bold">Clock</div>
								<div class="custom-control custom-switch my-2">
									<input type="checkbox" class="custom-control-input" name="clock" id="clock" v-model="appData.clock.is_enabled" />
									<label class="custom-control-label" for="clock"></label>
								</div>
							</div>
						</div>
					</div>
					<div class="mt-4">
						<h2>Misc</h2>
						<div class="container-fluid">
							<div class="row justify-content-between align-items-center border-top border-bottom cursor-on-hover px-2 py-2">
								<div class="col px-0">
									<div class="font-weight-bold">
										Slideshow Delay <span><small>(Seconds)</small></span>
									</div>
								</div>
								<div class="col-5 col-md-3 px-0">
									<input
										class="form-control form-control-sm glass"
										type="number"
										:placeholder="slideshowDelayInSeconds"
										name="slideshow_delay"
										id="slideshow_delay"
										min="0"
										step="1"
										@input="evt => $emit('updateSlideshowDelay', evt.target.value * 1000)"
										value="slideshowDelayInSeconds"
									/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer d-none">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
					<button type="button" class="btn btn-primary">
						Save changes
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "settings-menu",
	props: ["appData"],
	computed: {
		options() {
			return Object.keys(this.displayOptions || {});
		},
		slideshowDelayInSeconds() {
			return Math.round(this.appData.misc.slideshow_delay / 1000);
		}
	}
};
</script>

<style></style>
