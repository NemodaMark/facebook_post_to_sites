<?php

// Set your Facebook App credentials
$appId = '917668766733923';
$appSecret = '7d48f76a8f7aa866b767c193dc2d1de1';
$pageId = '551065584994104';
$accessToken = 'EAANCnWjc1mMBOZCUyJZB26SkK0EVoHFRUOPB54o1PnGeRug2nUZAUuzcElacCBfFuSJSKZBFCvDYLmwgTBU7n8zebQflCa2BVI7ZAn6JZA2oTGoTuBkdXLBZC2FJTLTJ09PAmmwMSRYtUVNLCsu9WSZC7dJZAoJeivlWAdVaVzqIOatmv56ZARxWOdOOWZB40EneKnYDQgRghf7Ez34pqHdAqw0B7ZA4GAEYSEc1eEtSB5o7';

// Make a request to the Facebook Graph API
$url = "https://graph.facebook.com/v13.0/{$pageId}/posts?fields=message,created_time,permalink_url&access_token={$accessToken}";

$response = file_get_contents($url);

if ($response === FALSE) {
    // Handle the error
    $errorMessage = "Error fetching data from the Facebook Graph API.";
} else {
    // Process the response
    $data = json_decode($response, true);

    // Check if the response contains an error message
    if (isset($data['error'])) {
        // Handle the error
        $errorMessage = "Error: " . $data['error']['message'];
    } elseif (!empty($data['data'])) {
        // Iterate over each post
        foreach ($data['data'] as $post) {
            // Exclude posts with no content available
            if(isset($post['message']) && $post['message'] !== "No content available") {
                // Extract post information
                $postDate = isset($post['created_time']) ? date('Y-m-d H:i:s', strtotime($post['created_time'])) : 'Unknown';
                $postContent = isset($post['message']) ? $post['message'] : 'No content available';
                $postLink = isset($post['permalink_url']) ? $post['permalink_url'] : '#';

                // Display each post
                echo "<div class='card bg-primary text-light mx-5 my-5' style='width: 18rem;'>
                        <div class='card-body'>
                            <h5 class='card-title'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle' viewBox='0 0 16 16'>
                                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>
                                    <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0'/>
                                </svg>
                                Information
                            </h5>
                            <h6 class='card-subtitle mb-2 text-light'>$postDate</h6>
                            <p class='card-text'>$postContent</p>
                            <a href='$postLink' class='card-link text-light'>Post Link</a>
                            <a href='https://www.facebook.com/profile.php?id=100066156733639&locale=hu_HU' class='card-link text-light'>facebook page</a>
                        </div>
                    </div>";
            }
        }
    } else {
        // Handle the case when no posts are found
        $errorMessage = "No posts found.";
    }
}

?>
