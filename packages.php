<section class="page-section bg-dark" id="home">
    <div class="container py-5">
        <?php
        if (!isset($_SESSION['userdata']) && !isset($_SESSION['user_id'])) {
            echo "<script>location.replace('./?page=login');</script>";
            exit;
        }


        $items_per_page = 6;
        $current_page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
        $offset = ($current_page - 1) * $items_per_page;
        ?>
        <h2 class="text-center text-white mb-4">Featured Destinations</h2>
        <div class="d-flex w-100 justify-content-center mb-4">
            <hr class="border-light" style="border:2px solid" width="10%">
        </div>

        <!-- Sort/Filter Section -->
        <div class="sort-filter-container mb-4 text-center bg-white p-3 rounded shadow-sm">
            <div class="d-flex justify-content-center flex-wrap">
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo !isset($_GET['sort']) || $_GET['sort'] == 'recommended' ? 'active' : '' ?>" onclick="sortPackages('recommended')">Recommended</button>
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo isset($_GET['sort']) && $_GET['sort'] == 'rating' ? 'active' : '' ?>" onclick="sortPackages('rating')">Traveler Rating</button>
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo isset($_GET['sort']) && $_GET['sort'] == 'popularity' ? 'active' : '' ?>" onclick="sortPackages('popularity')">Popularity</button>
            </div>
        </div>

        <script>
            function sortPackages(type) {
                window.location.href = `./?page=packages&sort=${type}&p=1`;
            }
        </script>

        <!-- Featured Spots Section -->
        <div class="row">
            <?php
            $sort_type = isset($_GET['sort']) ? $_GET['sort'] : 'recommended';

            // Get total count for pagination
            $count_query = "SELECT COUNT(*) as total FROM packages WHERE status = 1";
            $total_result = $conn->query($count_query);
            $total_items = $total_result->fetch_assoc()['total'];
            $total_pages = ceil($total_items / $items_per_page);

            // Main query with pagination
            switch ($sort_type) {
                case 'rating':
                    $query = "
                        SELECT p.*, IFNULL(AVG(r.rate), 0) AS avg_rating
                        FROM packages p
                        LEFT JOIN rate_review r ON p.id = r.package_id
                        WHERE p.status = 1
                        GROUP BY p.id
                        ORDER BY avg_rating DESC
                        LIMIT $offset, $items_per_page
                    ";
                    break;

                case 'popularity':
                    $query = "
                        SELECT p.*, COUNT(r.id) AS review_count
                        FROM packages p
                        LEFT JOIN rate_review r ON p.id = r.package_id
                        WHERE p.status = 1
                        GROUP BY p.id
                        ORDER BY review_count DESC
                        LIMIT $offset, $items_per_page
                    ";
                    break;

                default:
                    $query = "SELECT * FROM packages WHERE status = 1 ORDER BY RAND() LIMIT $offset, $items_per_page";
                    break;
            }

            $packages = $conn->query($query);

            while ($row = $packages->fetch_assoc()) :
                $cover = '';
                if (is_dir(base_app . 'uploads/package_' . $row['id'])) {
                    $img = scandir(base_app . 'uploads/package_' . $row['id']);
                    $k = array_search('.', $img);
                    if ($k !== false) unset($img[$k]);
                    $k = array_search('..', $img);
                    if ($k !== false) unset($img[$k]);
                    $cover = isset($img[2]) ? 'uploads/package_' . $row['id'] . '/' . $img[2] : "";
                }

                $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));

                $review = $conn->query("SELECT * FROM `rate_review` WHERE package_id='{$row['id']}'");
                $review_count = $review->num_rows;
                $rate = 0;
                while ($r = $review->fetch_assoc()) {
                    $rate += $r['rate'];
                }
                if ($rate > 0 && $review_count > 0) {
                    $rate = number_format($rate / $review_count, 0, "");
                }
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm rounded-lg package-item">
                        <div class="position-relative">
                            <img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo $row['title'] ?>" height="200rem" style="object-fit:cover">
                            <?php if ($review_count > 0) : ?>
                                <div class="position-absolute top-0 end-0 bg-primary text-dark px-2 py-1 m-2 rounded">
                                    <small><i class="fa fa-star"></i> <?php echo $rate ?>/5</small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark fw-bold"><?php echo $row['title'] ?></h5>
                            <div class="d-flex align-items-center mb-2">


                            </div>

                            <p class="card-text text-muted small"><?php echo substr($row['description'], 0, 100) . '...'; ?></p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                            <div class="me-5 fw-bold <?php echo isset($row['cost']) && strtolower(trim($row['cost'])) == 'free entry' ? 'text-success' : 'text-primary'; ?>">
                                <?php if (isset($row['cost']) && strtolower(trim($row['cost'])) == 'free entry') : ?>
                                    <span><?php echo ucfirst($row['cost']); ?></span>
                                <?php else : ?>
                                    <span><?php echo htmlspecialchars($row['cost']); ?></span>
                                <?php endif; ?>
                            </div>
                            <a href="./?page=view_package&id=<?php echo md5($row['id']) ?>" class="btn btn-sm btn-primary">View Details <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($current_page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="./?page=packages&sort=<?php echo $sort_type ?>&p=<?php echo $current_page - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $show_pages = 5; // Number of page links to show
                    $start_page = max(1, $current_page - floor($show_pages / 2));
                    $end_page = min($total_pages, $start_page + $show_pages - 1);

                    if ($end_page - $start_page + 1 < $show_pages) {
                        $start_page = max(1, $end_page - $show_pages + 1);
                    }

                    for ($i = $start_page; $i <= $end_page; $i++) :
                    ?>
                        <li class="page-item <?php echo $i == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="./?page=packages&sort=<?php echo $sort_type ?>&p=<?php echo $i ?>"><?php echo $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="./?page=packages&sort=<?php echo $sort_type ?>&p=<?php echo $current_page + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>