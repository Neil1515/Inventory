<!-- ccscalendar.php -->
<?php
// Fetch events from tblborrowingreports with itemreqstatus as "Approved"
$events_query = "SELECT * FROM tblborrowingreports WHERE itemreqstatus = 'Approved'";
$events_result = mysqli_query($con, $events_query);

$events = array();

if ($events_result) {
    while ($row = mysqli_fetch_assoc($events_result)) {
        // Customize the event title to include borrower ID and item ID
        $title = 'Borrower ID: ' . $row['borrowerid'] . ', Item ID: ' . $row['itemid'];

        // Check if 'datimereturn' key exists in the row array
        $end_date = isset($row['datimereturn']) ? $row['datimereturn'] : ''; 

        $event = array(
            'title' => $title,
            'start' => $row['datimeapproved'],
            'end' => $end_date,
            'url' => 'event-details.php?id=' . $row['id'] // Link to event details page
        );

        $events[] = $event;
    }
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
<div class="ccs-main-container">
    <div class="container">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h3 class="text-start"><i class="fas fa-calendar-alt me-2"></i>Calendar</h3>
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
                if (event.url) {
                    window.location = event.url;
                    return false;
                }
            },
            eventOverlap: false // Prevent events from overlapping
        });
    });
</script>
