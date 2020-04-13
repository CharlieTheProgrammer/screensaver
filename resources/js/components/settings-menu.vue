<template>
	<!-- Modal -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content glass glass-font">
				<div class="modal-header d-none">
					<h5 class="modal-title" id="exampleModalCenterTitle">
						Modal title
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
							<div
								class="row justify-content-between align-items-center border-top border-bottom cursor-on-hover px-2"
								@click="toggleOption(option)"
								v-for="option in options"
								:key="option"
							>
								<div class="font-weight-bold">{{ option | ucFirst }}</div>
								<div><input class="my-3" type="checkbox" :name="option" :id="option" v-model="data[option]" /></div>
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
	data() {
		return {
			options: ["links", "clock", "weather", "search", "focus"],
			data: {}
		};
	},
	filters: {
		ucFirst(string) {
			return _.upperFirst(string);
		}
	},
	mounted() {
		this.options.map(option => {
			Vue.set(this.data, option, false);
		});
	},
	methods: {
		toggleOption(option) {
			this.data[option] = !this.data[option];
		}
	}
};
</script>

<style></style>
