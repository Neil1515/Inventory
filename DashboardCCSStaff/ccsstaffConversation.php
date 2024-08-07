<!-- ccsstaffConversation.php -->
<?php
session_start();
// Include necessary files
include('ccsfunctions.php');
// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}
// Retrieve user information based on the logged-in user ID
$staffId = $_SESSION['staff_id'];

$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $staffId);

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

// Fetch the name of the user based on the sender ID in the URL parameter
if(isset($_GET['sender_id'])) {
    $senderId = $_GET['sender_id'];

    $query = "SELECT fname, lname FROM tblusers WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $senderId);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $senderInfo = mysqli_fetch_assoc($result);
                $senderName = $senderInfo['fname'] . ' ' . $senderInfo['lname'];
            } else {
                // Handle the case when user information is not found
                $senderName = "Unknown User";
            }
        } else {
            $senderName = "Unknown User";
        }
        mysqli_stmt_close($stmt);
    } else {
        $senderName = "Unknown User";
    }

    // Update the status of messages from the sender as read by the recipient
    $update_query = "UPDATE tblmessage_recipients SET status = 'read' WHERE recipient_id = ? AND message_id IN (SELECT id FROM tblmessages WHERE sender_id = ?)";
    $stmt_update = mysqli_prepare($con, $update_query);

    if ($stmt_update) {
        mysqli_stmt_bind_param($stmt_update, "ii", $staffId, $senderId);

        if (mysqli_stmt_execute($stmt_update)) {
            // Messages marked as read successfully
        } else {
            echo "Error marking messages as read: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt_update);
    } else {
        echo "Statement preparation failed: " . mysqli_error($con);
    }
} else {
    $senderName = "Unknown User";
}

// Handle form submission to send a reply
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['message'])) {
        // Sanitize input to prevent SQL injection
        $message = mysqli_real_escape_string($con, $_POST['message']);

        // Insert the staff's reply into the database
        $insert_message_query = "INSERT INTO tblmessages (sender_id, message) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $insert_message_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "is", $staffId, $message);

            if (mysqli_stmt_execute($stmt)) {
                // Get the ID of the inserted message
                $message_id = mysqli_insert_id($con);

                // Insert recipient information into tblmessage_recipients table
                $insert_recipient_query = "INSERT INTO tblmessage_recipients (message_id, recipient_id) VALUES (?, ?)";
                $stmt_recipient = mysqli_prepare($con, $insert_recipient_query);

                if ($stmt_recipient) {
                    mysqli_stmt_bind_param($stmt_recipient, "ii", $message_id, $senderId);

                    if (mysqli_stmt_execute($stmt_recipient)) {
                        // Reply sent successfully
                        header("Location: ccsstaffConversation.php?sender_id=$senderId");
                        exit();
                    } else {
                        echo "Error inserting recipient: " . mysqli_error($con);
                    }
                } else {
                    echo "Statement preparation failed: " . mysqli_error($con);
                }
            } else {
                echo "Error sending reply: " . mysqli_error($con);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Statement preparation failed: " . mysqli_error($con);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Conversation</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="staffstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">      
            <?php include('ccsheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('ccssidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-7">
                <div class="container-fluid">
                <div class="message-container">
        <!-- Display conversation header -->
        <h3 class="mb-4">
        <?php
         // Check if the user has a profile image
         if (!empty($senderId)) {
            // Check if the profile image exists
            $profileImagePath = "/inventory/images/imageofusers/$senderId.png";
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profileImagePath)) {
                // If the user has a profile image, display it with a timestamp
                echo '<img src="' . $profileImagePath . '?' . time() . '"  width="30" height="30">';
            } else {
                // If the profile image does not exist, display the default image with a timestamp
                echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '"  width="30" height="30">';
            }
        } else {
            // If senderId is empty, display the default image with a timestamp
            echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '"  width="30" height="30">';
        }
        ?>
        <a href="ccstaffBorrowerProfile.php?borrower_id=<?php echo $senderId; ?>"><?php echo $senderName; ?></a></h3>
    <!-- Display conversation messages -->
    <div class="message-box" id="message-box">
        <!-- Inside the div with class="message-box" -->
        <?php
// Display conversation messages
$query_messages = "SELECT m.*, u.fname, u.lname 
                   FROM tblmessages m 
                   INNER JOIN tblusers u ON m.sender_id = u.id
                   WHERE (m.sender_id = ? AND m.id IN (SELECT message_id FROM tblmessage_recipients WHERE recipient_id = ?)) 
                      OR (m.sender_id = ? AND m.id IN (SELECT message_id FROM tblmessage_recipients WHERE recipient_id = ?))
                   ORDER BY m.id ASC"; // Fetch messages in ascending order of their IDs
$stmt_messages = mysqli_prepare($con, $query_messages);

if ($stmt_messages) {
    mysqli_stmt_bind_param($stmt_messages, "iiii", $senderId, $staffId, $staffId, $senderId);
    if (mysqli_stmt_execute($stmt_messages)) {
        $result_messages = mysqli_stmt_get_result($stmt_messages);
        
        while ($row = mysqli_fetch_assoc($result_messages)) {
            $message_content = $row['message'];
            if ($row['sender_id'] == $senderId) {
                // Borrower message or sender name
                echo '<div class="message borrower-message">' . $message_content . '</div>';
            } else {
                // Staff message
                echo '<div class="message staff-message">' . $message_content . '</div>';
            }
        }
    } else {
        echo "Error executing statement to fetch messages: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt_messages);
} else {
    echo "Statement preparation failed to fetch messages: " . mysqli_error($con);
}

?>

    </div>
    <!-- Message input form -->
    <form method="post" action="" class="message-form" id="message-form">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Type your message here..." name="message" required>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
        </div>
    </form>
</div>
                </div>
            </div>
            <!-- Available users sidebar -->
            <div class="col-md-3">
                <?php include('ccsavailableusers.php'); ?>
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
        a {
        text-decoration: none;
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
        .staff-message {
            align-self: flex-end;
            background-color: #007bff;
            color: #fff;
        }
        .borrower-message {
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
        img {
        width: 40px;
        height: 40px;
        cursor: pointer;
        border-radius: 50%;
        align-items: center;
        margin-left: 5px;
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