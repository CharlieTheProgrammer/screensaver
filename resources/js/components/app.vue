<template>
	<div>
		<div id="modals-container">
			<settings-menu @updateDisplayOptions="data => (this.display_options = data)"></settings-menu>
		</div>
		<div class="flex-center position-ref full-height">
			<div class="content">
				<welcome-box></welcome-box>
				<clock class="top-right" v-if="display_options.clock"></clock>

				<div id="footer" class="fixed-bottom pb-2 text-light">
					<table class="w-100">
						<td style="width:33%" class="text-left pl-3">
							<a class="cursor-on-hover" data-toggle="modal" data-target="#settings-menu">
								<i data-feather="settings"></i>
							</a>
							<span class="pl-2">{{ getImageUserName(current_image) }}</span>
						</td>
						<td class="text-center" style="width:33%">
							<span class="badge glass cursor-on-hover" @click="fadeToggle('welcome-box')"><i data-feather="more-horizontal"></i></span>
						</td>
						<td style="width:33%"></td>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		images: {
			type: Array,
			default: []
		}
	},
	data() {
		return {
			// images: [],
			current_image: {},
			display_options: {
				clock: db.get("display_options") && db.get("display_options").clock,
				slideshow_delay: (db.get("display_options") && db.get("display_options").slideshow_delay) || 60000
			}
		};
	},
	created() {
		// Set default image
		$("body").css({
			background: 'url("/images/unsplash.jpg")',
			"background-position": "50% 50%",
			"background-repeat": "no-repeat",
			"background-size": "cover"
		});

		if (this.images.length > 0) {
			// Store images
			db.set("images", this.images);

			// Start loop to go over the images
			let current_image_index = 0;
			setInterval(() => {
				this.current_image = this.images[(current_image_index = ++current_image_index % this.images.length)];
				this.setBackgroundImage(this.current_image);
			}, this.display_options.slideshow_delay || 60000);
			// Set the first image immediately
			this.setBackgroundImage(this.images[(current_image_index = ++current_image_index % this.images.length)])
		}
	},
	methods: {
		setBackgroundImage(image) {
			$("body").css({
				background: `url(${image.urls.regular})`,
				"background-position": "50% 50%",
				"background-repeat": "no-repeat",
				"background-size": "cover"
			});
		},
		fadeToggle(elementId) {
			$("#" + elementId).fadeToggle();
		},
		fadeMeOut(elementId) {
			$("#" + elementId).fadeOut();
		},
		fadeMeIn(elementId) {
			$("#" + elementId).fadeIn();
		},
		nextImage() {
			return db.get("images")[0];
		},
		removeImage() {
			const updated_images = db.get("images").splice(0, 1);
			db.set("images", updated_images);
		},
		getImageUserName(image) {
			return (image.user && image.user.name) || "";
		}
	}
};
</script>

<style></style>
