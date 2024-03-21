<?php
// Output the container and search input
echo '<div class="ccs-main-container">';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="d-flex justify-content-between">';
echo '<h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>List of Pending Borrowers</h3>';
echo '<div class="text-end">';
echo '<input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">';
echo '</div>';
echo '</div>';
echo '<div class="">';
echo '<a href="#"  class="btn btn-danger me-2">Pending Reservation</a>';
echo '<a href="#"  class="btn btn-primary">Accepted Reservation</a>';
echo '</div>';

?>