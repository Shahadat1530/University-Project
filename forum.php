<?php
    include 'connection.php'; // Connection to your database

    // Check if a question is submitted
    if(isset($_POST['submit_question'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $question = mysqli_real_escape_string($con, $_POST['question']);
        
        // Insert the question into the forum table with parent_id = 0
        $sql = "INSERT INTO forum (name, question, parent_id) VALUES ('$name', '$question', 0)";
        mysqli_query($con, $sql);
    }

    // Check if a reply is submitted
    if(isset($_POST['submit_reply'])) {
        $forum_id = mysqli_real_escape_string($con, $_POST['forum_id']);
        $replier_name = mysqli_real_escape_string($con, $_POST['replier_name']);
        $reply_message = mysqli_real_escape_string($con, $_POST['reply_message']);
        
        // Insert the reply into the forum table with parent_id equal to the question's ID
        $sql = "INSERT INTO forum (name, question, parent_id) VALUES ('$replier_name', '$reply_message', '$forum_id')";
        mysqli_query($con, $sql);
    }
    
    // Fetch all questions from the forum table where parent_id = 0 (i.e., only the questions)
    $sql = "SELECT * FROM forum WHERE parent_id = 0 ORDER BY created_at DESC";
    $forum_result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <!-- Tailwind Framework Link -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">

    <style>
        .poppins {
            font-family: "Poppins", sans-serif;
        }
    </style>
</head>

<body class="poppins bg-gray-100">
    <header class="bg-gray-200">
        <nav class="max-w-screen-2xl mx-auto">
            <div class="navbar">
                <div class="navbar-start">
                    <a class="text-2xl font-bold">Chittagong Independent University</a>
                </div>
                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="forum.php">Forum</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
                <div class="navbar-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img alt="logo" src="images/logo.png">
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="max-w-screen-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow">
        <!-- Ask button and input field -->
        <button class="btn btn-success mb-4" id="askButton">Ask</button>

        <!-- Input form for asking a question (hidden initially) -->
        <div id="inputField" class="hidden mb-6">
            <form method="POST" action="" class="space-y-4">
                <input type="text" name="name" id="userName" placeholder="Your name" required class="input input-bordered w-full">
                <input type="text" name="question" id="userInput" placeholder="Ask your question..." required class="input input-bordered w-full">
                <div class="flex space-x-4">
                    <button type="submit" name="submit_question" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" id="cancelButton">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Script to toggle ask question form visibility -->
        <script>
            document.getElementById('askButton').addEventListener('click', function() {
                document.getElementById('inputField').classList.toggle('hidden');
            });

            document.getElementById('cancelButton').addEventListener('click', function() {
                document.getElementById('inputField').classList.add('hidden');
                document.getElementById('userInput').value = ''; // Clear input
            });
        </script>

        <!-- Display the Q&A Section -->
        <section>
            <h4 class="text-2xl font-bold mb-6">Q&A</h4>
            <div class="space-y-6">
                <?php 
                while ($forum_row = mysqli_fetch_array($forum_result)) { 
                    $forum_id = $forum_row['id']; 
                ?>
                    <div class="bg-gray-50 p-6 rounded-lg shadow">
                        <p><strong><?php echo $forum_row['name']; ?>:</strong> <?php echo $forum_row['question']; ?></p>

                        <!-- Reply button and form for each question -->
                        <button class="btn btn-secondary mt-4 replyButton" data-id="<?php echo $forum_id; ?>">Reply</button>

                        <!-- Reply form (hidden initially) -->
                        <div id="replyField<?php echo $forum_id; ?>" class="hidden mt-4">
                            <form method="POST" action="" class="space-y-4">
                                <input type="hidden" name="forum_id" value="<?php echo $forum_id; ?>">
                                <input type="text" name="replier_name" placeholder="Your name" required class="input input-bordered w-full">
                                <input type="text" name="reply_message" placeholder="Write your reply..." required class="input input-bordered w-full">
                                <button type="submit" name="submit_reply" class="btn btn-primary">Submit</button>
                            </form>
                        </div>

                        <!-- Display replies for this question -->
                        <?php
                        // Fetch all replies where parent_id equals the question's ID
                        $reply_sql = "SELECT * FROM forum WHERE parent_id = '$forum_id' ORDER BY created_at ASC";
                        $reply_result = mysqli_query($con, $reply_sql);

                        while ($reply_row = mysqli_fetch_array($reply_result)) {
                        ?>
                            <div class="ml-6 mt-4 bg-white p-4 rounded-lg shadow">
                                <p><strong><?php echo $reply_row['name']; ?>:</strong> <?php echo $reply_row['question']; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </section>

        <!-- Script to toggle reply form visibility for each question -->
        <script>
            document.querySelectorAll('.replyButton').forEach(button => {
                button.addEventListener('click', function() {
                    const forumId = this.getAttribute('data-id');
                    document.getElementById('replyField' + forumId).classList.toggle('hidden');
                });
            });
        </script>
    </div>
</body>

</html>

