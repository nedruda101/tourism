<style>
  /* Custom styles for cards */
  .analytics-card {
    transition: transform 0.3s, box-shadow 0.3s;
    border: none;
    border-radius: 15px;
    background: linear-gradient(145deg, #ffffff, #f8f9fa);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .analytics-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  }

  .analytics-card .card-title {
    color: #1a3c34;
    font-weight: 600;
  }

  .analytics-card .card-text {
    color: #ff6f61;
    font-weight: bold;
  }

  .analytics-card i {
    color: #28a745;
    margin-right: 10px;
  }

  /* Style for popular destinations */
  .list-group-item {
    border: none;
    padding: 10px 15px;
    font-size: 1.1rem;
    color: #333;
    background: transparent;
  }

  .list-group-item:hover {
    background: #e9ecef;
    border-radius: 10px;
  }

  .list-group-item .rating {
    font-size: 0.9rem;
    color: #ff6f61;
    margin-left: 5px;
  }

  /* Chart container */
  #analyticsChart {
    max-height: 250px;
  }

  /* Animation for card load */
  .analytics-card {
    animation: fadeIn 0.5s ease-in;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<h1 class="text-center mb-4" style="color: #1a3c34; font-weight: 700;">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="w-50 mx-auto mb-5" style="border: 2px solid #ff6f61;">
<div class="container">
  <div class="row">
    <!-- Destination Inquiries -->
    <div class="col-md-4 mb-4">
      <div class="card analytics-card">
        <div class="card-body text-center">
          <i class="fas fa-envelope fa-2x mb-3"></i>
          <h5 class="card-title">Destination Inquiries</h5>
          <?php
          $total_inquiries = $conn->query("SELECT COUNT(id) as total FROM `inquiry`")->fetch_assoc()['total'];
          ?>
          <p class="card-text display-4"><?php echo $total_inquiries; ?></p>
        </div>
      </div>
    </div>

    <!-- Registered Visitors -->
    <div class="col-md-4 mb-4">
      <div class="card analytics-card">
        <div class="card-body text-center">
          <i class="fas fa-users fa-2x mb-3"></i>
          <h5 class="card-title">Registered Visitors</h5>
          <?php
          $total_users = $conn->query("SELECT COUNT(id) as total FROM `users`")->fetch_assoc()['total'];
          ?>
          <p class="card-text display-4"><?php echo $total_users; ?></p>
        </div>
      </div>
    </div>

    <!-- Pie Chart for Inquiries and Visitors -->
    <div class="col-md-4 mb-4">
      <div class="card analytics-card">
        <div class="card-body">
          <h5 class="card-title text-center">Visitor Engagement</h5>
          <?php if ($total_inquiries == 0 && $total_users == 0) : ?>
            <p class="text-center text-muted">No data available for the chart.</p>
          <?php else : ?>
            <canvas id="analyticsChart"></canvas>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Popular Destinations with Average Rating -->
    <div class="col-md-12 mb-4">
      <div class="card analytics-card">
        <div class="card-body">
          <h5 class="card-title"><i class="fas fa-map-marker-alt me-2"></i>Popular Destinations</h5>
          <?php
          $popular_destinations = $conn->query("SELECT p.id, p.title, AVG(r.rate) as avg_rating, COUNT(r.id) as review_count
                                                  FROM `packages` p 
                                                  LEFT JOIN `rate_review` r ON p.id = r.package_id
                                                  GROUP BY p.id, p.title 
                                                  HAVING COUNT(r.id) > 0
                                                  ORDER BY AVG(r.rate) DESC, COUNT(r.id) DESC 
                                                  LIMIT 3");
          ?>
          <ul class="list-group list-group-flush">
            <?php while ($row = $popular_destinations->fetch_assoc()) : ?>
              <li class="list-group-item">
                <i class="fas fa-star text-warning me-2"></i>
                <?php echo $row['title']; ?>
                <span class="rating">
                  <?php echo $row['avg_rating'] ? number_format($row['avg_rating'], 1) . '/5 (' . $row['review_count'] . ')' : 'N/A'; ?>
                </span>
              </li>
            <?php endwhile; ?>
            <?php if ($popular_destinations->num_rows == 0) : ?>
              <li class="list-group-item text-muted">No rated destinations available.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Chart.js Pie Chart
  document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('analyticsChart')?.getContext('2d');
    if (ctx) {
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['Inquiries', 'Registered Visitors'],
          datasets: [{
            data: [<?php echo $total_inquiries; ?>, <?php echo $total_users; ?>],
            backgroundColor: ['#ff6f61', '#28a745'],
            borderColor: '#fff',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: '#1a3c34'
              }
            },
            tooltip: {
              enabled: true
            }
          }
        }
      });
    }
  });
</script>