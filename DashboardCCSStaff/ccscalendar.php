<!-- ccscalendar.php -->
<?php
// Fetch events from tblborrowingreports and join with tblusers and tblitembrand to get borrower names and item subcategory names
$events_query = "SELECT br.*, CONCAT(u.fname, ' ', u.lname) AS borrower_name, GROUP_CONCAT(ib.subcategoryname SEPARATOR ', ') AS item_names 
                 FROM tblborrowingreports AS br 
                 LEFT JOIN tblusers AS u ON br.borrowerid = u.id
                 LEFT JOIN tblitembrand AS ib ON FIND_IN_SET(ib.id, br.itemid)
                 WHERE br.itemreqstatus='Approve Reserve'
                 GROUP BY br.id";
$events_result = mysqli_query($con, $events_query);

$events = array();

if ($events_result) {
    $grouped_events = array(); // Initialize an array to store grouped events
    while ($row = mysqli_fetch_assoc($events_result)) {
        // Get the datetime requested to borrow
        $datetime = $row['datetimereserve'];
    
        // Format the date and time
        $formattedDateTime = date('h:iA F-d-Y', strtotime($datetime));
    
        // Check if there's already an event at this datetime
        if (isset($grouped_events[$datetime])) {
            // Append the current item names to the existing group
            $grouped_events[$datetime]['title'] .= ', ' . $row['item_names'];
        } else {
            // Create a new event group
            $grouped_events[$datetime] = array(
                'title' => "<i class='fas fa-user me-2'></i><strong>" . $row['borrower_name'] . '</strong><br>Request to reserve item ' . $row['item_names'],                
                'start' => $datetime,
                'end' => isset($row['datetimeapproved']) ? $row['datetimeapproved'] : '',
                'url' => 'ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=' . $row['borrowerid'] // Include borrower ID in URL
            );
        }
    }
    
    // Convert the grouped events to the required format
    $events = array_values($grouped_events);
}
?>

<style>
    /* Custom CSS for calendar container */
    #calendar {
        max-width: 99%;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
</style>
<!-- Modal HTML Structure -->
<div class="modal fade" id="reqtoborrowModal" tabindex="-1" aria-labelledby="reqtoborrowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reqtoborrowModalLabel">Reservation <?php echo $formattedDateTime; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary" id="viewBtn">View</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="ccs-main-container">
    <div class="container">
        <div class="row table-responsive">
            <div class="d-flex justify-content-between">
                <h3 class="text-start"><i class="fas fa-calendar-alt me-2"></i>Reservation calendar</h3>
                <div class="text-end">
                    <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
                </div>
            </div>
            <div class="text-end mb-1">
                <a href="ccsstaffDashboardPage.php" class="btn btn-danger">Back</a>
            </div>
            <!-- Calendar -->
            <div id="calendar"></div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- FullCalendar JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        editable: true,
        eventLimit: true,
        events: <?php echo json_encode($events); ?>,
        eventClick: function(event) {
            $('#reqtoborrowModal .modal-body label').html(event.title); // Use html() instead of text()
            $('#reqtoborrowModal').modal('show');

            // Set the href attribute of the View button to the correct URL with borrower ID
            $('#viewBtn').attr('href', event.url);

            return false; // Prevent default event behavior
        },
        eventOverlap: false, // Prevent events from overlapping
        eventRender: function(event, element) {
            element.find('.fc-title').html(event.title); // Allow HTML in event titles
        }
    });
});
</script>
