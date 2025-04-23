<style>
	header.masthead {
		background-image: url('<?php echo validate_image($_settings->info('cover')) ?>') !important;
	}

	header.masthead .container {
		background: #0000006b;
	}
</style>
<!-- Masthead-->
<header class="masthead">
	<div class="container">
		<div class="masthead-subheading"></div>
		<div class="masthead-heading text-uppercase">Discover Attractions & Local Insights</div>
		<a class="btn btn-primary btn-xl text-uppercase" href="#home">View Tourist Spot</a>
	</div>
</header>
<!-- Services-->
<section class="page-section bg-dark" id="home">
	<div class="container">
		<h2 class="text-center">Featured Tourist Spots</h2>
		<div class="d-flex w-100 justify-content-center">
			<hr class="border-warning" style="border:3px solid" width="30%">
		</div>
		<div class="row">
			<?php
			$user_preference = isset($_SESSION['userdata']['preference']) ? $_SESSION['userdata']['preference'] : '';
			$max_display = 6;
			$displayed_ids = [];
			$packages = [];

			// Step 1: Get preference-based packages
			if (!empty($user_preference)) {
				$preferences = explode(',', $user_preference);
				$likes = [];

				foreach ($preferences as $pref) {
					$pref = $conn->real_escape_string(trim($pref));
					$likes[] = "`category` LIKE '%$pref%'";
				}

				if (!empty($likes)) {
					$preferred_query = "SELECT * FROM `packages` WHERE " . implode(" OR ", $likes) . " LIMIT $max_display";
					$result = $conn->query($preferred_query);
					if ($result && $result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$packages[] = $row;
							$displayed_ids[] = $row['id'];
						}
					}
				}

				// Step 2: Fill with random packages if less than $max_display
				$remaining = $max_display - count($packages);
				if ($remaining > 0) {
					$exclude_ids = implode(",", array_map('intval', $displayed_ids));
					$fallback_query = "SELECT * FROM `packages` " . (!empty($exclude_ids) ? "WHERE `id` NOT IN ($exclude_ids)" : "") . " ORDER BY RAND() LIMIT $remaining";
					$fallback_result = $conn->query($fallback_query);
					if ($fallback_result && $fallback_result->num_rows > 0) {
						while ($row = $fallback_result->fetch_assoc()) {
							$packages[] = $row;
						}
					}
				}
			} else {
				// No preferences? Just show 6 random
				$result = $conn->query("SELECT * FROM `packages` ORDER BY RAND() LIMIT $max_display");
				if ($result && $result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						$packages[] = $row;
					}
				}
			}

			// Step 3: Display the packages
			foreach ($packages as $row) :
				// Cover image
				$cover = '';
				$packageDir = base_app . 'uploads/package_' . $row['id'];
				if (is_dir($packageDir)) {
					$img = array_values(array_diff(scandir($packageDir), ['.', '..']));
					if (!empty($img)) {
						$cover = 'uploads/package_' . $row['id'] . '/' . $img[0];
					}
				}

				$row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));

				// Rating
				$rate = 0;
				$review = $conn->query("SELECT * FROM `rate_review` WHERE package_id='{$row['id']}'");
				$review_count = $review->num_rows;
				while ($r = $review->fetch_assoc()) {
					$rate += $r['rate'];
				}
				if ($rate && $review_count) {
					$rate = number_format($rate / $review_count, 0, "");
				}
			?>
				<div class="col-md-4 p-4">
					<div class="card w-100 rounded-0">
						<img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo htmlspecialchars($row['title']) ?>" height="200rem" style="object-fit:cover">
						<div class="card-body">
							<h5 class="card-title truncate-1 w-100"><?php echo htmlspecialchars($row['title']) ?></h5><br>
							<p class="card-text truncate"><?php echo htmlspecialchars($row['description']) ?></p>
							<div class="w-100 d-flex justify-content-end">
								<?php if (isset($_SESSION['userdata'])) : ?>
									<a href="./?page=view_package&id=<?php echo md5($row['id']) ?>" class="btn btn-sm btn-flat btn-warning">View Details <i class="fa fa-arrow-right"></i></a>
								<?php else : ?>
									<a href="javascript:void(0)" class="btn btn-sm btn-flat btn-warning" onclick="uni_modal('Login', 'login.php', 'large')">View Details <i class="fa fa-arrow-right"></i></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>





	</div>
</section>
<!-- About-->
<section class="page-section" id="about">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">About Us</h2>
		</div>
		<div>
			<div class="card w-100">
				<div class="card-body">
					<?php echo file_get_contents(base_app . 'about.html') ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Contact-->
<section class="page-section" id="contact">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">Contact Us</h2>
			<h3 class="section-subheading text-muted">Send us a message for inquiries.</h3>
		</div>
		<!-- * * * * * * * * * * * * * * *-->
		<!-- * * SB Forms Contact Form * *-->
		<!-- * * * * * * * * * * * * * * *-->
		<!-- This form is pre-integrated with SB Forms.-->
		<!-- To make this form functional, sign up at-->
		<!-- https://startbootstrap.com/solution/contact-forms-->
		<!-- to get an API token!-->
		<form id="contactForm">
			<div class="row align-items-stretch mb-5">
				<div class="col-md-6">
					<div class="form-group">
						<!-- Name input-->
						<input class="form-control" id="name" name="name" type="text" placeholder="Your Name *" required />
					</div>
					<div class="form-group">
						<!-- Email address input-->
						<input class="form-control" id="email" name="email" type="email" placeholder="Your Email *" data-sb-validations="required,email" />
					</div>
					<div class="form-group mb-md-0">
						<input class="form-control" id="subject" name="subject" type="subject" placeholder="Subject *" required />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group form-group-textarea mb-md-0">
						<!-- Message input-->
						<textarea class="form-control" id="message" name="message" placeholder="Your Message *" required></textarea>
					</div>
				</div>
			</div>
			<div class="text-center"><button class="btn btn-primary btn-xl text-uppercase" id="submitButton" type="submit">Send Message</button></div>
		</form>
	</div>
</section>
<script>
	$(function() {
		$('#contactForm').submit(function(e) {
			e.preventDefault()
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_inquiry",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				error: err => {
					console.log(err)
					alert_toast("an error occured", 'error')
					end_loader()
				},
				success: function(resp) {
					if (typeof resp == 'object' && resp.status == 'success') {
						alert_toast("Inquiry sent", 'success')
						$('#contactForm').get(0).reset()
					} else {
						console.log(resp)
						alert_toast("an error occured", 'error')
						end_loader()
					}
				}
			})
		})
	})
</script>