<?php
session_start();

function checkDownload($memberType) {
    // Check if session variables are initialized for non-members
    if (!isset($_SESSION['downloads_nonmember'])) {
        $_SESSION['downloads_nonmember'] = [];
    }
    
    // Check if session variables are initialized for members
    if (!isset($_SESSION['downloads_member'])) {
        $_SESSION['downloads_member'] = [];
    }

    // Current time
    $currentTime = time();
    
    // Remove timestamps older than 5 seconds for non-members
    $_SESSION['downloads_nonmember'] = array_filter($_SESSION['downloads_nonmember'], function($timestamp) use ($currentTime) {
        return ($currentTime - $timestamp) <= 5;
    });

    // Remove timestamps older than 5 seconds for members
    $_SESSION['downloads_member'] = array_filter($_SESSION['downloads_member'], function($timestamp) use ($currentTime) {
        return ($currentTime - $timestamp) <= 5;
    });

    // Count recent downloads for non-members
    $downloadCount_nonmember = count($_SESSION['downloads_nonmember']);

    // Count recent downloads for members
    $downloadCount_member = count($_SESSION['downloads_member']);

    if ($memberType == 'member') {
        if ($downloadCount_member < 2) {
            // Members can download up to 2 times consecutively without waiting
            $_SESSION['downloads_member'][] = $currentTime;
            return "Your download is starting... \n";
        } else {
            // For the 3rd download and more, members must wait 5 seconds since the last download
            if ($currentTime - end($_SESSION['downloads_member']) < 5) {
                return "Too many downloads \n";
            } else {
                $_SESSION['downloads_member'][] = $currentTime;
                return "Your download is starting... \n";
            }
        }
    } else if ($memberType == 'nonmember') {
        // Non-members must wait 5 seconds between each download
        if ($downloadCount_nonmember > 0 && ($currentTime - end($_SESSION['downloads_nonmember']) < 5)) {
            return "Too many downloads \n";
        } else {
            $_SESSION['downloads_nonmember'][] = $currentTime;
            return "Your download is starting... \n";
        }
    } else {
        return "Invalid member type \n";
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