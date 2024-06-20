<?php

/*
Explanation to this mini project:
Step 1: Define base probabilities for the item tiers. Add new items or adjust probabilities as needed.
Step 2: Adjust probabilities based on VIP Levels. In the code below, VIP level 1 increases probabilities of getting item 1 and 2 by 10%. 
        (Add more VIP levels or modify the probabilities as needed)
Step 3: Normalize the adjusted probabilities to ensure they sum up to 100%.
Step 4: Loop the function 100 times to check the result.
*/


function roll_item($vip_rank) {
    // Base item tier probabilities (add more items as needed)
    $base_probabilities = [
        1 => 0.5,   // common
        2 => 0.2,   // uncommon
        3 => 0.15,  // rare
        4 => 0.1,   // epic
        5 => 0.05   // legendary
    ];
    
    // Adjust probabilities based on the VIP level
    $adjusted_probabilities = $base_probabilities;
    
    // VIP level adjustments (add more VIP level and adjust the probabilities as needed)
    switch ($vip_rank) {
        case 'v1':
            $adjusted_probabilities[1] += 0.1;  // increase common
            $adjusted_probabilities[2] += 0.1;  // increase uncommon
            break;
        case 'v2':
            $adjusted_probabilities[1] += 0.1;  // increase common
            $adjusted_probabilities[2] += 0.1;  // increase uncommon
            $adjusted_probabilities[3] += 0.1;  // increase rare
            break;
        case 'v3':
            $adjusted_probabilities[1] += 0.1;  // increase common
            $adjusted_probabilities[2] += 0.1;  // increase uncommon
            $adjusted_probabilities[3] += 0.1;  // increase rare
            $adjusted_probabilities[4] += 0.1;  // increase epic
            break;
        // Add more cases for additional VIP levels as needed
        default:
            break;
    }
    
    // Normalize probabilities
    $total_probability = array_sum($adjusted_probabilities);
    foreach ($adjusted_probabilities as &$prob) {
        $prob /= $total_probability;
    }
    
    // Generate a random number to determine the item tier
    $random = mt_rand() / mt_getrandmax();
    $cumulativeProbability = 0;
    foreach ($adjusted_probabilities as $tier => $probability) {
        $cumulativeProbability += $probability;
        if ($random <= $cumulativeProbability) {
            return $tier;  // return the item tier
        }
    }
}

// Loop 100 times and print the item distribution result
function simulateRolls() {
    $vip_ranks = ['v1', 'v2', 'v3', 'v4', 'v5'];
    $rolls = 100;
    $itemCounts = [];

    // Initialize itemCounts object with zeros for each VIP rank
    foreach ($vip_ranks as $vip) {
        $itemCounts[$vip] = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];
    }

    // Simulate rolls for each VIP rank
    foreach ($vip_ranks as $vip) {
        for ($i = 0; $i < $rolls; $i++) {
            $item = roll_item($vip);
            $itemCounts[$vip][$item]++;
        }
    }

    // Print the results
    foreach ($vip_ranks as $vip) {
        $result = "[$vip] => ";
        for ($tier = 1; $tier <= 5; $tier++) {
            $result .= "{$itemCounts[$vip][$tier]} ";
        }
        echo trim($result) . "\n";
    }
}

// Example usage:
$newRoll = roll_item("v1");
echo "Single roll result: $newRoll\n\n";

simulateRolls();

/* Result:
Single roll result: 2

[v1] => 54 23 10 8 5 
[v2] => 42 22 23 9 4 
[v3] => 44 26 11 15 4 
[v4] => 48 19 19 10 4 
[v5] => 45 29 13 6 7 
*/

?>