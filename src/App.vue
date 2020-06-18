<template>
	<div id="app">
		<div id="modals-container">
			<settings-menu :appData="app_data" @updateSlideshowDelay="data => (this.app_data.misc.slideshow_delay = data)"></settings-menu>
		</div>
		<div class="flex-center position-ref full-height">
			<div class="content">
				<welcome-box @fetchImages="search_term => fetchImages(search_term)"></welcome-box>
				<clock class="top-right" v-if="app_data.clock.is_enabled"></clock>

				<div id="footer" class="fixed-bottom pb-2 text-light">
					<table class="w-100">
						<td style="width:33%" class="text-left pl-3">
							<a class="cursor-on-hover" data-toggle="modal" data-target="#settings-menu">
								<i data-feather="settings"></i>
							</a>
							<span class="pl-2">{{ getImageUserName(current_image) }}</span>
						</td>
						<td class="text-center" style="width:33%">
							<span class="badge glass cursor-on-hover" @click="handleWelcomeBoxToggle()"><i data-feather="more-horizontal"></i></span>
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
	data() {
		return {
			app_data: {},
			images: [],
			current_image: {},
			total_pages: 0,
			interval: 0,
		};
	},
	created() {
		this.initAppData();
    setTimeout(() => feather.replace(), 500);
		const images = db.get("images");
		if (images && images.length > 0) {
			this.images = images;
			this.runImagesLoop();
		} else {
			// Set default image
			$("body").css({
				background: 'url("/images/unsplash.jpg")',
				"background-position": "50% 50%",
				"background-repeat": "no-repeat",
				"background-size": "cover"
			});
		}

		this.welcomeBoxFadeEffects();
	},
	methods: {
		initAppData() {
			let default_app_data = {
				clock: {
					is_enabled: false
				},
				welcome_box: {
					is_enabled: true
				},
				misc: {
					slideshow_delay: constants.DEFAULT_SLIDESHOW_DELAY,
					welcome_box_fade_out: constants.WELCOME_BOX_FADE_OUT
				}
			};

			let saved_app_data = db.get("app_data") || {};
			this.app_data = { ...default_app_data, ...saved_app_data, ...{ welcome_box: { is_enabled: true } } };
		},
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
		},
		handleWelcomeBoxToggle() {
			this.app_data.welcome_box.is_enabled = !this.app_data.welcome_box.is_enabled;
			this.fadeToggle("welcome-box");
		},
		welcomeBoxFadeEffects() {
			if (this.images.length === 0) return;

			var idleTime = 0;
			$(document).ready(() => {
				//Increment the idle time counter every minute.
				let idleInterval = setInterval(timerIncrement, constants.WELCOME_BOX_FADE_OUT);

				//Zero the idle timer on mouse movement.
				$(document).mousemove(e => {
					if (this.app_data.welcome_box.is_enabled) $("#welcome-box").fadeIn();
					idleTime = 0;
				});
				$(document).keypress(e => {
					$("#welcome-box").fadeIn();
					if (this.app_data.welcome_box.is_enabled) $("#welcome-box").fadeIn();
					idleTime = 0;
				});

				function timerIncrement() {
					idleTime = idleTime + 1;
					if (idleTime > 1) {
						$("#welcome-box").fadeOut();
					}
				}
			});
		},
		fetchImages(search_term) {
			axios
				// I'm limited to 30 per page regardless if I increase the per_page parameter.
				.get(`/search/photos?query=${search_term}&per_page=30`)
				.then(({ data }) => {
					this.total_pages = data.total_pages;
					this.images = _.shuffle(data.results);
					if (this.interval) clearInterval(this.interval);
					this.runImagesLoop();
				})
				.catch(err => {
					console.log(err);
				});
		},
		runImagesLoop() {
			if (this.images.length > 0) {
				// Store images
				db.set("images", this.images);

				// Start loop to go over the images
				let current_image_index = 0;
				this.interval = setInterval(() => {
					this.current_image = this.images[(current_image_index = ++current_image_index % this.images.length)];
					this.setBackgroundImage(this.current_image);
				}, this.app_data.misc.slideshow_delay);

				// Set the first image immediately
				this.setBackgroundImage(this.images[(current_image_index = ++current_image_index % this.images.length)]);
			}
		}
	},
	watch: {
		app_data: {
			handler(val) {
				db.set("app_data", val);
			},
			deep: true
		},
		slideshow_delay(val) {
			db.set("slideshow_delay", val);
		}
	}
};
</script>

<style></style>
