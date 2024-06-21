<?php
session_start();

function checkDownload($memberType) {
    // Ensure session variables are initialized
    if (!isset($_SESSION['downloads'])) {
        $_SESSION['downloads'] = [
            'nonmember' => [],
            'member' => []
        ];
    }

    // Current time
    $currentTime = time();

    // Remove timestamps older than 5 seconds
    $_SESSION['downloads']['nonmember'] = array_filter($_SESSION['downloads']['nonmember'], function($timestamp) use ($currentTime) {
        return ($currentTime - $timestamp) <= 5;
    });

    $_SESSION['downloads']['member'] = array_filter($_SESSION['downloads']['member'], function($timestamp) use ($currentTime) {
        return ($currentTime - $timestamp) <= 5;
    });

    if ($memberType === 'member') {
        $downloadCount = count($_SESSION['downloads']['member']);

        if ($downloadCount < 2) {
            // Members can download up to 2 times consecutively without waiting
            $_SESSION['downloads']['member'][] = $currentTime;
            return "Your download is starting...\n";
        } else {
            // For the 3rd download and more, members must wait 5 seconds since the last download
            if ($currentTime - end($_SESSION['downloads']['member']) < 5) {
                return "Too many downloads\n";
            } else {
                $_SESSION['downloads']['member'][] = $currentTime;
                return "Your download is starting...\n";
            }
        }
    } elseif ($memberType === 'nonmember') {
        $downloadCount = count($_SESSION['downloads']['nonmember']);

        // Non-members must wait 5 seconds between each download
        if ($downloadCount > 0 && ($currentTime - end($_SESSION['downloads']['nonmember']) < 5)) {
            return "Too many downloads\n";
        } else {
            $_SESSION['downloads']['nonmember'][] = $currentTime;
            return "Your download is starting...\n";
        }
    } else {
        return "Invalid member type\n";
    }
}

// Example usage
echo checkDownload('nonmember'); // Your download is starting...
sleep(3); 
echo checkDownload('nonmember'); // Too many downloads
sleep(3);
echo checkDownload('nonmember'); // Your download is starting...

echo checkDownload('member'); // Your download is starting...
sleep(3);
echo checkDownload('member'); // Your download is starting...
sleep(1);
echo checkDownload('member'); // Too many downloads
sleep(2);
echo checkDownload('member'); // Your download is starting...

?>
