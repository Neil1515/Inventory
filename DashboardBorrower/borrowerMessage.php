<!-- borrowerMessage.php -->
<?php
session_start();

// Include necessary files
include('bwerfunctions.php');

// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}

// Retrieve user information based on the logged-in user ID
$borrowerId = $_SESSION['borrower_id'];

$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
        } else {
            // Handle the case when user information is not found
            // You might want to redirect or display an error message
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}

// Handle message sending
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    // Insert message into tblmessages table
    $insert_message_query = "INSERT INTO tblmessages (sender_id, message) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $insert_message_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $borrowerId, $message);
        if (mysqli_stmt_execute($stmt)) {
            $message_id = mysqli_insert_id($con);

            // Get recipient IDs for CCS Staff
            $recipient_query = "SELECT id FROM tblusers WHERE usertype = 'CCS Staff'";
            $recipient_result = mysqli_query($con, $recipient_query);

            if ($recipient_result && mysqli_num_rows($recipient_result) > 0) {
                while ($recipient_row = mysqli_fetch_assoc($recipient_result)) {
                    $recipient_id = $recipient_row['id'];

                    // Insert recipient IDs into tblmessage_recipients table
                    $insert_recipient_query = "INSERT INTO tblmessage_recipients (message_id, recipient_id) VALUES (?, ?)";
                    $stmt_recipient = mysqli_prepare($con, $insert_recipient_query);
                    if ($stmt_recipient) {
                        mysqli_stmt_bind_param($stmt_recipient, "ii", $message_id, $recipient_id);
                        mysqli_stmt_execute($stmt_recipient);
                    } else {
                        echo "Error inserting recipient: " . mysqli_error($con);
                    }
                }
                mysqli_free_result($recipient_result);
            }
            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt_recipient);
            // Redirect with success message
            header('Location: borrowerMessage.php?msg_success=Message sent successfully');
            exit();
        } else {
            // Redirect with error message
            header('Location: borrowerMessage.php?msg_fail=Failed to send message');
            exit();
        }
    } else {
        die('Statement preparation failed: ' . mysqli_error($con));
    }
}

// Fetch conversation history with staff names
$conversation_query = "SELECT m.message, m.sender_id, m.timestamp, CONCAT(u.fname, ' ', u.lname) AS staff_name
                       FROM tblmessages m 
                       INNER JOIN tblusers u ON m.sender_id = u.id 
                       WHERE m.sender_id = ? OR m.id IN (SELECT message_id FROM tblmessage_recipients WHERE recipient_id = ?)
                       ORDER BY m.timestamp"; // Order by timestamp to display the most recent messages at the bottom
$stmt_conversation = mysqli_prepare($con, $conversation_query);
if ($stmt_conversation) {
    mysqli_stmt_bind_param($stmt_conversation, "ii", $borrowerId, $borrowerId);
    if (mysqli_stmt_execute($stmt_conversation)) {
        $conversation_result = mysqli_stmt_get_result($stmt_conversation);
    } else {
        echo "Error executing conversation query: " . mysqli_error($con);
    }
} else {
    echo "Statement preparation failed: " . mysqli_error($con);
}

// Update the status of unread messages to "read"
$updateQuery = "UPDATE tblmessage_recipients SET status = 'read' WHERE recipient_id = ? AND status = 'unread'";
$updateStmt = mysqli_prepare($con, $updateQuery);
if ($updateStmt) {
    mysqli_stmt_bind_param($updateStmt, "i", $borrowerId);
    if (mysqli_stmt_execute($updateStmt)) {
        // Unread messages marked as read successfully
    } else {
        // Handle error
        echo "Error updating unread messages: " . mysqli_error($con);
    }
    mysqli_stmt_close($updateStmt);
} else {
    // Handle error
    echo "Statement preparation failed: " . mysqli_error($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Message to Staff</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">      
                <?php include('bwerheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('bwersidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-10">
                <div class="container-fluid">
                    <div class="message-container">
                        <h3 class="mb-4">Message to CCS Staff</h3>
                        <div class="message-box" id="message-box">
                            <?php
                            if (isset($conversation_result) && mysqli_num_rows($conversation_result) > 0) {
                                while ($conversation_row = mysqli_fetch_assoc($conversation_result)) {
                                    if ($conversation_row['sender_id'] == $borrowerId) {
                                        // Borrower's message
                                        echo '<div class="message user-message">';
                                        echo $conversation_row['message'];
                                        echo '</div>';
                                    } else {
                                        // Staff's message
                                        echo '<div class="message staff-message">';
                                        echo '<strong>' . $conversation_row['staff_name'] . '</strong>: ' . $conversation_row['message'];
                                        echo '</div>';
                                    }
                                }
                                mysqli_free_result($conversation_result);
                            } else {
                                echo '<div class="alert alert-info" role="alert">No conversation history found.</div>';
                            }
                            ?>
                        </div>
                        <form method="post" action="" class="message-form" id="message-form">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type your message here..." name="message" required>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .message-container {
            max-width: auto;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message-box {
            max-height: 450px; /* Set max height */
            overflow-y: auto; /* Enable vertical scrolling */
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .message {
            padding: 10px 15px;
            border-radius: 10px;
            max-width: 70%;
        }
        .user-message {
            align-self: flex-end;
            background-color: #007bff;
            color: #fff;
        }
        .staff-message {
            align-self: flex-start;
            background-color: #f0f0f0;
            color: #333;
        }
        .input-group {
            margin-top: 20px;
        }

        /* Hide the scrollbar */
        .message-box::-webkit-scrollbar {
            width: 0px; /* Remove scrollbar width */
        }
    </style>

    <script>
        // Function to scroll to the bottom of the message box
        function scrollToBottom() {
            var messageBox = document.getElementById("message-box");
            messageBox.scrollTop = messageBox.scrollHeight;
        }

        // Call the scrollToBottom function when the page loads
        window.onload = function() {
            scrollToBottom();
        };

        // Call the scrollToBottom function after a new message is sent
        document.getElementById("message-form").addEventListener("submit", function() {
            setTimeout(scrollToBottom, 100); // Adjust delay if needed
        });
    </script>
</body>
</html>
