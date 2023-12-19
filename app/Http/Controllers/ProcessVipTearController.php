<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcessVipTearController extends Controller
{
    public function processFromAjax(Request $request)
    {

        $vip_rank = explode(',', $request->input('param1')); // Splitting into an array based on ', ' separator
        $item_tier_rarity = explode(',', $request->input('param2'));

        // Function to generate rarity weights based on VIP rank and item tiers
        function generate_weights($vip_rank, $item_tier_rarity)
        {
            $weights = [];

            foreach ($vip_rank as $vIndex => $rank) {
                foreach ($item_tier_rarity as $tIndex => $tier) {
                    $weights[$rank][$tier] = (5 - $tier + $vIndex) * 1.5; // Adjust the formula for weight calculation
                }
            }

            return $weights;
        }

        // Function to roll an item based on VIP rank
        function roll_item($vip_rank, $item_tier_rarity, $rarity_weights)
        {
            $weights = $rarity_weights[$vip_rank];
            $total_weight = array_sum($weights);

            // Check if total weight is greater than 0
            if ($total_weight > 0) {
                $random_weight = mt_rand(1, $total_weight);

                foreach ($item_tier_rarity as $tier) {
                    $random_weight -= $weights[$tier];
                    if ($random_weight <= 0) {
                        return $tier;
                    }
                }
            }

            // Return a default value when total weight is 0 or negative
            return 1; // Return -1 as a default error status or choose a default tier
        }

        // Generate rarity weights based on VIP rank and item tiers
        $rarity_weights = generate_weights($vip_rank, $item_tier_rarity);

        // Simulate and get item distribution
        $itemDistribution = [];
        foreach ($vip_rank as $rank) {
            $items_distribution = array_fill_keys($item_tier_rarity, 0);

            for ($i = 0; $i < 100; $i++) {
                $item = roll_item($rank, $item_tier_rarity, $rarity_weights);
                $items_distribution[$item]++;
            }

            $itemDistribution[$rank] = $items_distribution;
        }

        return $itemDistribution;
    }
}
