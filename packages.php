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
        $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
        $category_filter = isset($_GET['categories']) && !empty($_GET['categories']) ? array_filter(explode(',', $_GET['categories']), 'is_numeric') : [];

        // Validate category IDs against categories table
        $valid_category_ids = [];
        $category_names = [];
        $category_query = "SELECT id, name FROM categories";
        $category_result = $conn->query($category_query);
        if ($category_result) {
            while ($row = $category_result->fetch_assoc()) {
                $valid_category_ids[] = (string)$row['id'];
                $category_names[$row['id']] = $row['name'];
            }
        }
        $category_filter = array_intersect($category_filter, $valid_category_ids);

        // Check if any packages match the selected categories
        $category_match_check = false;
        if (!empty($category_filter)) {
            $check_conditions = [];
            foreach ($category_filter as $cat_id) {
                $safe_cat_id = $conn->real_escape_string($cat_id);
                $check_conditions[] = "JSON_CONTAINS(category, '\"$safe_cat_id\"')";
            }
            $check_query = "SELECT COUNT(*) as count FROM location WHERE status = 1 AND (" . implode(" OR ", $check_conditions) . ")";
            $check_result = $conn->query($check_query);
            if ($check_result) {
                $category_match_check = $check_result->fetch_assoc()['count'] > 0;
            }
            error_log("Category Match Check Query: $check_query");
        }

        $category_sql = "";
        if (!empty($category_filter)) {
            $conditions = [];
            foreach ($category_filter as $cat_id) {
                $safe_cat_id = $conn->real_escape_string($cat_id);
                $conditions[] = "JSON_CONTAINS(category, '\"$safe_cat_id\"')";
            }
            $category_sql = " AND (" . implode(" OR ", $conditions) . ")";
            error_log("Category SQL: $category_sql");
        }
        ?>
        <h2 class="text-center text-white mb-4">Featured Destinations</h2>
        <div class="d-flex w-100 justify-content-center mb-4">
            <hr class="border-light" style="border:2px solid" width="10%">
        </div>

        <!-- Sort/Filter and Search Section -->
        <div class="sort-filter-container mb-4 text-center bg-white p-3 rounded shadow-sm">
            <div class="d-flex justify-content-center flex-wrap align-items-center">
                <!-- Search Bar -->
                <div class="input-group w-25 mb-2 mx-2 me-auto">
                    <input type="text" class="form-control" id="search-input" placeholder="Search destinations..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button class="btn btn-primary" type="button" onclick="searchPackages()">Search</button>
                </div>
                <!-- Sort Buttons -->
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo !isset($_GET['sort']) || $_GET['sort'] == 'recommended' ? 'active' : '' ?>" onclick="sortPackages('recommended')">Recommended</button>
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo isset($_GET['sort']) && $_GET['sort'] == 'rating' ? 'active' : '' ?>" onclick="sortPackages('rating')">Traveler Rating</button>
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo isset($_GET['sort']) && $_GET['sort'] == 'popularity' ? 'active' : '' ?>" onclick="sortPackages('popularity')">Popularity</button>
                <button class="btn btn-outline-dark m-1 sort-filter-btn <?php echo isset($_GET['sort']) && $_GET['sort'] == 'free' ? 'active' : '' ?>" onclick="sortPackages('free')">Free Entry</button>
            </div>

            <!-- Category Filters -->
            <div class="d-flex justify-content-right flex-wrap mt-3">
                <?php
                $category_query = "SELECT id, name FROM categories ORDER BY name ASC";
                $category_result = $conn->query($category_query);
                if ($category_result && $category_result->num_rows > 0) {
                    while ($category = $category_result->fetch_assoc()) {
                        $cat_id = $category['id'];
                        $cat_name = htmlspecialchars($category['name']);
                        $checked = in_array((string)$cat_id, $category_filter) ? 'checked' : '';
                        echo "<label class='mx-2'>";
                        echo "<input type='checkbox' class='category-filter' value='$cat_id' $checked> $cat_name";
                        echo "</label>";
                    }
                } else {
                    echo "<p class='text-muted'>No categories available. Please add categories in the admin panel.</p>";
                }
                ?>
                <button class="btn btn-sm btn-secondary ms-3" onclick="applyCategoryFilter()">Apply Filter</button>
            </div>
        </div>

        <script>
            function sortPackages(type) {
                const search = document.getElementById('search-input').value;
                const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);
                const categoryParam = selectedCategories.join(',');
                const isCurrentlyActive = <?php echo isset($_GET['sort']) ? "'" . $_GET['sort'] . "'" : "'recommended'" ?> === type;

                let url;
                if (isCurrentlyActive) {
                    url = `./?page=packages&search=${encodeURIComponent(search)}&p=1`;
                    if (selectedCategories.length > 0) {
                        url += `&categories=${encodeURIComponent(categoryParam)}`;
                    }
                } else {
                    url = `./?page=packages&sort=${type}&search=${encodeURIComponent(search)}&p=1`;
                    if (selectedCategories.length > 0) {
                        url += `&categories=${encodeURIComponent(categoryParam)}`;
                    }
                }
                window.location.href = url;
            }

            function searchPackages() {
                const search = document.getElementById('search-input').value;
                const sort = '<?php echo isset($_GET['sort']) ? $_GET['sort'] : 'recommended'; ?>';
                const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);

                let url = `./?page=packages&p=1`;

                if (sort !== 'recommended') {
                    url += `&sort=${sort}`;
                }

                if (search) {
                    url += `&search=${encodeURIComponent(search)}`;
                }

                if (selectedCategories.length > 0) {
                    url += `&categories=${encodeURIComponent(selectedCategories.join(','))}`;
                }

                window.location.href = url;
            }

            function applyCategoryFilter() {
                const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);
                const search = document.getElementById('search-input').value;
                const sort = '<?php echo isset($_GET['sort']) ? $_GET['sort'] : 'recommended'; ?>';

                let url = `./?page=packages&p=1`;

                if (sort !== 'recommended') {
                    url += `&sort=${sort}`;
                }

                if (search) {
                    url += `&search=${encodeURIComponent(search)}`;
                }

                if (selectedCategories.length > 0) {
                    url += `&categories=${encodeURIComponent(selectedCategories.join(','))}`;
                }

                window.location.href = url;
            }

            document.getElementById('search-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchPackages();
                }
            });
        </script>

        <div class="row">
            <?php
            $sort_type = isset($_GET['sort']) ? $_GET['sort'] : 'recommended';

            $count_query = "SELECT COUNT(*) as total FROM packages WHERE status = 1";
            if (!empty($search_query)) {
                $count_query .= " AND title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
            }
            $count_query .= $category_sql;
            error_log("Count Query: $count_query");

            $total_result = $conn->query($count_query);
            if (!$total_result) {
                echo '<p class="text-center text-white">Error executing count query: ' . htmlspecialchars($conn->error) . '</p>';
                $total_items = 0;
                $total_pages = 0;
            } else {
                $total_items = $total_result->fetch_assoc()['total'];
                $total_pages = ceil($total_items / $items_per_page);
            }

            switch ($sort_type) {
                case 'rating':
                    $query = "
                        SELECT p.*, IFNULL(AVG(r.rate), 0) AS avg_rating
                        FROM packages p
                        LEFT JOIN rate_review r ON p.id = r.package_id
                        WHERE p.status = 1
                    ";
                    if (!empty($search_query)) {
                        $query .= " AND p.title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                    }
                    $query .= $category_sql;
                    $query .= "
                        GROUP BY p.id
                        ORDER BY avg_rating DESC
                        LIMIT $offset, $items_per_page
                    ";
                    break;
                case 'free':
                    $query = "SELECT * FROM packages WHERE status = 1 AND LOWER(cost) LIKE '%free entry%'";
                    if (!empty($search_query)) {
                        $query .= " AND title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                    }
                    $query .= $category_sql;
                    $query .= " ORDER BY title ASC LIMIT $offset, $items_per_page";
                    break;
                case 'popularity':
                    $query = "
                        SELECT p.*, COUNT(r.id) AS review_count
                        FROM packages p
                        LEFT JOIN rate_review r ON p.id = r.package_id
                        WHERE p.status = 1
                    ";
                    if (!empty($search_query)) {
                        $query .= " AND p.title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                    }
                    $query .= $category_sql;
                    $query .= "
                        GROUP BY p.id
                        ORDER BY review_count DESC
                        LIMIT $offset, $items_per_page
                    ";
                    break;
                default:
                    $user_preference = isset($_SESSION['userdata']['preference']) ? $_SESSION['userdata']['preference'] : '';

                    if (!empty($user_preference)) {
                        // Check if preference is already stored as JSON
                        $preference_array = json_decode($user_preference, true);

                        if (json_last_error() === JSON_ERROR_NONE && is_array($preference_array)) {
                            // If it's valid JSON, use the category IDs directly
                            $category_ids = $preference_array;
                        } else {
                            // If it's a comma-separated string of category names, convert to IDs
                            $preferences = array_map('trim', explode(',', $user_preference));
                            $pref_names = implode("','", array_map(array($conn, 'real_escape_string'), $preferences));
                            $category_query = "SELECT id FROM categories WHERE name IN ('$pref_names')";
                            $category_result = $conn->query($category_query);
                            $category_ids = [];
                            if ($category_result) {
                                while ($row = $category_result->fetch_assoc()) {
                                    $category_ids[] = $row['id'];
                                }
                            }
                        }

                        $packages = [];
                        $displayed_ids = [];

                        // Base query for packages
                        $base_query = "SELECT * FROM packages WHERE status = 1";
                        if (!empty($search_query)) {
                            $base_query .= " AND title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                        }
                        $base_query .= $category_sql;

                        if (!empty($category_ids)) {
                            // Step 1: Fetch packages that match user preferences
                            $conditions = [];
                            foreach ($category_ids as $cat_id) {
                                $safe_cat_id = $conn->real_escape_string($cat_id);
                                $conditions[] = "JSON_CONTAINS(category, '\"$safe_cat_id\"')";
                            }
                            $preferred_query = $base_query . " AND (" . implode(" OR ", $conditions) . ")";
                            $preferred_query .= " LIMIT $offset, $items_per_page";
                            error_log("Preferred Query: $preferred_query");

                            $result = $conn->query($preferred_query);
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $packages[] = $row;
                                    $displayed_ids[] = $row['id'];
                                }
                            }

                            // Step 2: If not enough packages, fill with remaining packages
                            if (count($packages) < $items_per_page) {
                                $remaining = $items_per_page - count($packages);
                                $exclude_ids = !empty($displayed_ids) ? implode(",", array_map('intval', $displayed_ids)) : "0";

                                $fallback_query = $base_query;
                                $fallback_query .= " AND id NOT IN ($exclude_ids)";
                                $fallback_query .= " ORDER BY RAND() LIMIT $remaining";
                                error_log("Fallback Query: $fallback_query");

                                $result = $conn->query($fallback_query);
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $packages[] = $row;
                                    }
                                }
                            }
                        } else {
                            // No valid category IDs found, fetch random packages
                            $query = $base_query . " ORDER BY RAND() LIMIT $offset, $items_per_page";
                            error_log("Random Query: $query");
                            $result = $conn->query($query);
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $packages[] = $row;
                                }
                            }
                        }
                    } else {
                        $query = "SELECT * FROM packages WHERE status = 1";
                        if (!empty($search_query)) {
                            $query .= " AND title LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                        }
                        $query .= $category_sql;
                        $query .= " ORDER BY RAND() LIMIT $offset, $items_per_page";
                        error_log("No Preference Query: $query");

                        $packages = [];
                        $result = $conn->query($query);
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $packages[] = $row;
                            }
                        }
                    }
                    break;
            }

            if ($sort_type != 'recommended' || (empty($user_preference) && empty($packages))) {
                $packages = [];
                error_log("Main Query: $query");
                $result = $conn->query($query);
                if (!$result) {
                    echo '<p class="text-center text-white">Error executing package query: ' . htmlspecialchars($conn->error) . '</p>';
                } elseif ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $packages[] = $row;
                    }
                }
            }

            if (empty($packages)) {
                $message = "No destinations found.";
                if (!empty($category_filter)) {
                    $category_labels = array_map(function ($id) use ($category_names) {
                        return isset($category_names[$id]) ? $category_names[$id] : "ID $id";
                    }, $category_filter);
                    $message .= " The selected categories (" . implode(", ", $category_labels) . ") do not match any packages.";
                    if (!$category_match_check) {
                        $message .= " No packages in the database have these category IDs in their category field.";
                    }
                }
                if (!empty($search_query)) {
                    $message .= " Try adjusting your search term or filters.";
                }
                $message .= " Check the admin panel to ensure packages are assigned to the selected categories.";
                echo '<p class="text-center text-white">' . $message . '</p>';
            }

            foreach ($packages as $row) :
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
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($current_page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="./?page=packages<?php echo isset($_GET['sort']) ? '&sort=' . $sort_type : ''; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&categories=' . urlencode(implode(',', $category_filter)) : ''; ?>&p=<?php echo $current_page - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $show_pages = 5;
                    $start_page = max(1, $current_page - floor($show_pages / 2));
                    $end_page = min($total_pages, $start_page + $show_pages - 1);

                    if ($end_page - $start_page + 1 < $show_pages) {
                        $start_page = max(1, $end_page - $show_pages + 1);
                    }

                    for ($i = $start_page; $i <= $end_page; $i++) :
                    ?>
                        <li class="page-item <?php echo $i == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="./?page=packages<?php echo isset($_GET['sort']) ? '&sort=' . $sort_type : ''; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&categories=' . urlencode(implode(',', $category_filter)) : ''; ?>&p=<?php echo $i ?>"><?php echo $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="./?page=packages<?php echo isset($_GET['sort']) ? '&sort=' . $sort_type : ''; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&categories=' . urlencode(implode(',', $category_filter)) : ''; ?>&p=<?php echo $current_page + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>