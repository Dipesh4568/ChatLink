<?php
session_start();

if (isset($_SESSION['username'])) {

    # database connection file
    include 'app/db.conn.php';

    include 'app/helpers/timeAgo.php';

    # Getting user
    include 'app/helpers/user.php';

    include 'app/helpers/chat.php';
    include 'app/helpers/opened.php';

    # Getting messages
    include 'app/ajax/insert.php';

    if (!isset($_GET['user'])) {
        header("Location: home.php");
        exit;
    }


    # Getting user data
    $chatWith = getUser($_GET['user'], $conn);

    if (empty($chatWith)) {
        header("Location: home.php");
        exit;
    }

    $chats = getChats($_SESSION['user_id'], $chatWith['user_id'], $conn);

    opened($chatWith['user_id'], $conn, $chats);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ChatLink - Chat</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="image/logo1.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>

    <body>
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="cont w-400 shadow p-4 rounded">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="uploads/<?= $chatWith['p_p'] ?>" class=" w-15 rounded-circle">
                        <h3 class="display-4 fs-sm m-2"><?= $chatWith['name'] ?><br>
                            <div class="d-flex align-items-center" title="online">

                                <?php if (last_seen($chatWith['last_seen']) == "Active") { ?>
                                    <div class="online"></div>
                                    <small class="d-block p-1">Online</small>
                                <?php } else { ?>
                                    <small class="d-block p-1">Last Seen: <?= last_seen($chatWith['last_seen']) ?></small>
                                <?php } ?>
                            </div>
                        </h3>
                    </div>
                    <div>
                        <a href="home.php"><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="blue" class="bi bi-x-circle justify-self-end" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg></a>
                    </div>
                </div>

                <div class="shadow p-4 rounded d-flex flex-column mt-3 chat-box" id="chatBox">

                    <?php if (!empty($chats)) {
                        foreach ($chats as $chat) {
                            if ($chat['from_id'] == $_SESSION['user_id']) { ?>
                                <p class="rtext align-self-end border rounded p-2 mb-2"><?= $chat['message'] ?><br><small class="d-block"><?= date('H:i:s a', strtotime($chat['created_at'])) ?></small></p>
                            <?php } else { ?>
                                <p class="ltext border rounded p-2 mb-2"><?= $chat['message'] ?><br><small class="d-block" style="color:white;"><?= date('H:i:s a', strtotime($chat['created_at'])) ?></small></p>
                            <?php }
                        }
                    } ?>

<?php if (empty($chats) && empty($_POST['message'])) { ?>
    <div class="alert alert-warning text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-envelope-plus-fill" viewBox="0 0 16 16">
            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 4.697v4.974A4.491 4.491 0 0 0 12.5 8a4.49 4.49 0 0 0-1.965.45l-.338-.207L16 4.697Z" />
            <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z" />
        </svg><br>
        No messages yet. Start the conversation.
    </div>
<?php } ?>

                </div>
                <div class="input-group mb-4 shadow" id="input_section">
                    <input id="message_input" type="text" class="form-control shadow" placeholder="Type here">
                    <button id="message_send_btn" style="width:20%" class="btn btn-primary shadow" id="button-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                        </svg></button>
                </div>
            </div>
        </div>

        <script>
            var scrollDown = function() {
                let chatBox = document.getElementById('chatBox');
                chatBox.scrollTop = chatBox.scrollHeight;
            }
            scrollDown();
            $(document).ready(function() {
                $("#message_input").on("keydown", function(event) {
                    if (event.keyCode === 13) { // 13 is the keycode for "Enter" key
                        event.preventDefault();
                        let message = $("#message_input").val().trim();
                        if (message !== "") {
                            $.post("app/ajax/insert.php", {
                                message: message,
                                to_id: <?= $chatWith['user_id'] ?>
                            }, function(data, status) {
                                $("#message_input").val("");
                                $("#chatBox").append(data);
                                scrollDown();
                            });
                        }
                    }
                });

                $("#message_send_btn").on("click", function() {
                    let message = $("#message_input").val().trim();
                    if (message !== "") {
                        $.post("app/ajax/insert.php", {
                            message: message,
                            to_id: <?= $chatWith['user_id'] ?>
                        }, function(data, status) {
                            $("#message_input").val("");
                            $("#chatBox").append(data);
                            scrollDown();
                        });
                    }
                });

                /* auto update last seen for logged in user_error */
                let lastSeenUpdate = function() {
                    $.get("app/ajax/update_last_seen.php");
                }
                lastSeenUpdate();

                /* auto update last seen every 10 sec */
                setInterval(lastSeenUpdate, 10000);

                /* auto refresh and reload */
                let fetchData = function() {
                    $.post("app/ajax/getMessage.php", {
                            id_2: <?= $chatWith['user_id'] ?>
                        },
                        function(data, status) {
                            $("#chatBox").append(data);
                            if (data.trim() !== "") scrollDown();
                        }
                    );
                };
                fetchData();

                /* auto update message every 0.5 sec */
                setInterval(fetchData, 500);
            });
        </script>

    </body>

    </html>
<?php
} else {
    header("Location: index.php");
    exit;
}
?>
